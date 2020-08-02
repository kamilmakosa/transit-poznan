<?php
namespace App;

require_once '../php-gtfs-realtime-parser/vendor/autoload.php';
use transit_realtime\FeedMessage;

class GTFSRealtime {
  /* Array with options:
  'path'            //path to file's folder
  'file'            //with .pb extensions
  'output-file'     //with .json extension
  */
  private $vehiclePositionsOptions;

  /* Array with options:
  'path'            //path to file's folder
  'file'            //with .pb extensions
  'output-file'     //with .json extension
  */
  private $tripUpdatesOptions;


  public function __construct($vehiclePositionsOptions, $tripUpdatesOptions) {
    $this->vehiclePositionsOptions = $vehiclePositionsOptions;
    $this->tripUpdatesOptions = $tripUpdatesOptions;
  }

  public function vehicle_positions_parse() {
    $options = $this->vehiclePositionsOptions;
    $data = file_get_contents($options['path'].'/'.$options['file']);

    $feed = new FeedMessage();
    $feed->parse($data);
    $output_data = Array();
    $entity_list = $feed->getEntityList();

    foreach($entity_list as $entity)
    {
    	$record = Array();
    	$vehiclePosition = $entity->getVehicle();

    	$tripDescriptor = $vehiclePosition->getTrip();
    	$record['tripId'] = $tripDescriptor->getTripId();
    	$record['routeId'] = $tripDescriptor->getRouteId();
    	$record['directionId'] = $tripDescriptor->getDirectionId();
    	$record['startTime'] = $tripDescriptor->getStartTime();
    	$record['startDate'] = $tripDescriptor->getStartDate();
    	$record['scheduleRelationship'] = $tripDescriptor->getScheduleRelationship();

    	$record['currentStopSequence'] = $vehiclePosition->getCurrentStopSequence();
    	$record['stopId'] = $vehiclePosition->getStopId();
    	$record['currentStatus'] = $vehiclePosition->getCurrentStatus();
    	$record['timestamp'] = $vehiclePosition->getTimestamp();
    	$record['congestionLevel'] = $vehiclePosition->getCongestionLevel();
    	$record['occupancyStatus'] = $vehiclePosition->getOccupancyStatus();

    	$vehicleDescriptor = $vehiclePosition->getVehicle();
    	$record['id'] = $vehicleDescriptor->getId();
    	$record['label'] = $vehicleDescriptor->getLabel();
    	$vehicleDescriptor->getLicensePlate();

    	$position = $vehiclePosition->getPosition();
    	$record['latitude'] = $position->getLatitude();
    	$record['longitude'] = $position->getLongitude();
    	$record['bearing'] = $position->getBearing();
    	$record['odometer'] = $position->getOdometer();
    	$record['speed'] = $position->getSpeed();

    	array_push($output_data, $record);
    }

    $this->json_write($output_data, $options['path'].'/'.$options['output-file']);
  }

  public function trip_updates_parse() {
    $options = $this->tripUpdatesOptions;
    $data = file_get_contents($options['path'].'/'.$options['file']);

    $feed = new FeedMessage();
    $feed->parse($data);
    $output_data = Array();
    $entity_list = $feed->getEntityList();

    foreach($entity_list as $entity)
    {
    	$record = Array();
    	$tripUpdate = $entity->getTripUpdate();

    	$tripDescriptor = $tripUpdate->getTrip();
    	$record['tripId'] = $tripDescriptor->getTripId();
    	$record['routeId'] = $tripDescriptor->getRouteId();
    	// $record['directionId'] = $tripDescriptor->getDirectionId();
    	// $record['startTime'] = $tripDescriptor->getStartTime();
    	// $record['startDate'] = $tripDescriptor->getStartDate();
    	$record['scheduleRelationship'] = $tripDescriptor->getScheduleRelationship();

    	$vehicleDescriptor = $tripUpdate->getVehicle();
    	$record['id'] = $vehicleDescriptor->getId();
    	// $record['label'] = $vehicleDescriptor->getLabel();
    	// $vehicleDescriptor->getLicensePlate();

    	$stopTimeUpdate = $tripUpdate->getStopTimeUpdate()[0];
    	$record['stopSequence'] = $stopTimeUpdate->getStopSequence();
    	// $record['stopId'] = $stopTimeUpdate->getStopId();

    	$arrival = $stopTimeUpdate->getArrival();
    	$record['arrival_delay'] = $arrival->delay;
    	// $record['arrival_time'] = $arrival->time;
    	// $record['arrival_uncertainty'] = $arrival->uncertainty;

    	if($stopTimeUpdate->hasDeparture()) {
    		$departure = $stopTimeUpdate->getDeparture();
    		// $record['departure_delay'] = $departure->delay;
    		// $record['departure_time'] = $departure->time;
    		// $record['departure_uncertainty'] = $departure->uncertainty;
    	}

    	//$record['timestamp'] = $tripUpdate->getTimestamp();
    	//$record['delay'] = $tripUpdate->getDelay();
    	array_push($output_data, $record);
    }

    $this->json_write($output_data, $options['path'].'/'.$options['output-file']);
  }

  private function json_write($data, $filepath) {
    $fp = fopen($filepath, 'w');
    fwrite($fp, json_encode($data, JSON_PRETTY_PRINT));
    fclose($fp);
  }

  public function pb_download($url, $filepath) {
    $command = 'curl "'.$url.'" --output '.$filepath;
    exec($command);
  }

  public function display_json($filepath) {
    echo file_get_contents($filepath);
  }
}
