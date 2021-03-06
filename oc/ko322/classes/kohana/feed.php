<?php defined('SYSPATH') or die('No direct script access.');
/**
 * RSS and Atom feed helper.
 *
 * @package    Kohana
 * @category   Helpers
 * @author     Kohana Team
 * @copyright  (c) 2007-2012 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class Kohana_Feed {

	/**
	 * Parses a remote feed into an array.
	 *
	 * @param   string  $feed   remote feed URL
	 * @param   integer $limit  item limit to fetch
	 * @return  array
	 */
	public static function parse($feed, $limit = 0)
	{
		// Check if SimpleXML is installed
		if ( ! function_exists('simplexml_load_file'))
			throw new Kohana_Exception('SimpleXML must be installed!');

		// Make limit an integer
		$limit = (int) $limit;

		// Disable error reporting while opening the feed
		$error_level = error_reporting(0);

		// Allow loading by filename or raw XML string
		$load = (is_file($feed) OR Valid::url($feed)) ? 'simplexml_load_file' : 'simplexml_load_string';

		// Load the feed
		$feed = $load($feed, 'SimpleXMLElement', LIBXML_NOCDATA);

		// Restore error reporting
		error_reporting($error_level);

		// Feed could not be loaded
		if ($feed === FALSE)
			return array();

		$namespaces = $feed->getNamespaces(true);

		// Detect the feed type. RSS 1.0/2.0 and Atom 1.0 are supported.
		$feed = isset($feed->channel) ? $feed->xpath('//item') : $feed->entry;

		$i = 0;
		$items = array();

		foreach ($feed as $item)
		{
			if ($limit > 0 AND $i++ === $limit)
				break;
			$item_fields = (array) $item;

			// get namespaced tags
			foreach ($namespaces as $ns)
			{
				$item_fields += (array) $item->children($ns);
			}
			$items[] = $item_fields;
		}

		return $items;
	}

	/**
	 * Creates a feed from the given parameters.
	 *
	 * @param   array   $info       feed information
	 * @param   array   $items      items to add to the feed
	 * @param   string  $format     define which format to use (only rss2 is supported)
	 * @param   string  $encoding   define which encoding to use
	 * @return  string
	 */
	public static function create($info, $items, $format = 'rss2', $encoding = 'UTF-8')
	{
		$info += array('title' => 'Generated Feed', 'link' => '', 'generator' => 'KohanaPHP');

		$feed = '<?xml version="1.0" encoding="'.$encoding.'"?><rss version="2.0"><channel></channel></rss>';
		$feed = simplexml_load_string($feed);

		foreach ($info as $name => $value)
		{
			if ($name === 'image')
			{
				// Create an image element
				  Kohana::$log->add(Log::INFO, "addChild(image)");

				$image = $feed->channel->addChild('image');

				if ( ! isset($value['link'], $value['url'], $value['title']))
				{
					throw new Kohana_Exception('Feed images require a link, url, and title');
				}

				if (strpos($value['link'], '://') === FALSE)
				{
					// Convert URIs to URLs
					$value['link'] = URL::site($value['link'], 'http');
				}

				if (strpos($value['url'], '://') === FALSE)
				{
					// Convert URIs to URLs
					$value['url'] = URL::site($value['url'], 'http');
				}

				// Create the image elements
				  Kohana::$log->add(Log::ERROR, "addChild(link)");
				  Kohana::$log->write();
				$image->addChild('link', $value['link']);
				  Kohana::$log->add(Log::INFO, "addChild(url)");
				$image->addChild('url', $value['url']);
				  Kohana::$log->add(Log::INFO, "addChild(title)");
				$image->addChild('title', $value['title']);
				  Kohana::$log->write();
			}
			else
			{
				if (($name === 'pubDate' OR $name === 'lastBuildDate') AND (is_int($value) OR ctype_digit($value)))
				{
					// Convert timestamps to RFC 822 formatted dates
					$value = date('r', $value);
				}
				elseif (($name === 'link' OR $name === 'docs') AND strpos($value, '://') === FALSE)
				{
					// Convert URIs to URLs
					$value = URL::site($value, 'http');
				}

				// Add the info to the channel
				$feed->channel->addChild($name, $value);
			}
		}

		foreach ($items as $item)
		{
			// Add the item to the channel
			$row = $feed->channel->addChild('item');

			foreach ($item as $name => $value)
			{
				if ($name === 'pubDate' AND (is_int($value) OR ctype_digit($value)))
				{
					// Convert timestamps to RFC 822 formatted dates
					$value = date('r', $value);
				}
				elseif (($name === 'link' OR $name === 'guid') AND strpos($value, '://') === FALSE)
				{
					// Convert URIs to URLs
					$value = URL::site($value, 'http');
				}

				// Add the info to the row
				Kohana::$log->add(Log::INFO, "$name->$value");
				Kohana::$log->write();
//				echo("$name->$value");
				

				if ($name == "description" || $name == "website") {
				  // Parse Markup
				      $child = $row->addChild($name);
				     $node = dom_import_simplexml( $child );
			     	   $no = $node->ownerDocument;
			       $node->appendChild( $no->createCDATASection( $value) );

				} else {
//				$value = htmlentities($value);	
				try{
				$row->addChild($name, $value);
				} catch (Exception $e) { 
				die("$name -> $value");
				}
				}


			}
		}

		if (function_exists('dom_import_simplexml'))
		{
			// Convert the feed object to a DOM object
			$feed = dom_import_simplexml($feed)->ownerDocument;

			// DOM generates more readable XML
			$feed->formatOutput = TRUE;

			// Export the document as XML
			$feed = $feed->saveXML();
		}
		else
		{
			// Export the document as XML
			$feed = $feed->asXML();
		}

		return $feed;
	}

} // End Feed
