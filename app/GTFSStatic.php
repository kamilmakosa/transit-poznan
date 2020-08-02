<?php

namespace App;
use DOMDocument;
use DOMXPath;
use stdClass;

class GTFSStatic
{
  public static function listGTFSFiles() {
    $html = file_get_contents('https://www.ztm.poznan.pl/pl/dla-deweloperow/gtfsFiles');
    $response = array();

    $dom = new DOMDocument();
    libxml_use_internal_errors(false);
    @$dom->loadHTML($html);

    $XPath = new DOMXPath($dom);
    $query = '/html/body/div[1]/section/div/div[2]/div/table[2]/tbody';
    $entries = $XPath->evaluate($query);
    $tbody = $entries->item(0);
    $tbody_length = $tbody->childNodes->length;

    for($key=$tbody_length-1; $key>=0; $key--) {
      $tr = $tbody->childNodes->item($key);
      if(!isset($tr->tagName)) {
        $tbody->removeChild($tbody->childNodes->item($key));
      }
    }

    while($tbody->childNodes->item(10)) {
    	$tbody->removeChild($tbody->childNodes->item(10)); //remove td>10
    }

    foreach($tbody->childNodes as $key => $item) {
      $item_length = $item->childNodes->length;
      for($key=$item_length-1; $key>=0; $key--) {
        $tr = $item->childNodes->item($key);
        if(!isset($tr->tagName)) {
          $item->removeChild($item->childNodes->item($key));
        }
      }

      $obj = new stdClass;
    	$obj->file = $item->childNodes->item(0)->textContent;
    	$obj->size = $item->childNodes->item(1)->textContent;
    	$obj->date = $item->childNodes->item(2)->textContent;
    	$obj->link = $item->childNodes->item(3)->childNodes->item(0)->attributes->item(0)->value;
      $response[] = $obj;
    }
    return $response;
  }
}
