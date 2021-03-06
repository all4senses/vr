<?php

/**
 * @file
 * Module constants list.
 */

// Ratings titles.
define('INSTALL', 'Installation Process');
define('FEATURES', 'Features');
define('PRICE', 'Price');
define('OVERALL', 'Overall Average Rating');

define('SOUND', 'Sound/Call Quality');
define('CUSTOMER', 'Customer Experience');
define('RELY', 'Service Reliability');
define('RECOMMEND', 'Would you recommend this VoIP provider?');

// Phones only
define('USE_EASE', 'Ease of Use');
define('VOICE', 'Voice Quality');
define('DURABILITY', 'Durability');
define('PERFORMANCE', 'Value Performance');
define('RECOMMEND_PHONE', 'Would you recommend this VoIP phone?');





// Fields hints.
define('FNAME_HINT', 'First');
define('LNAME_HINT', 'Last');
define('EMAIL_HINT', 'Enter a valid email');
define('PROS_HINT', 'Optional');
define('CONS_HINT', 'Optional');

// Provider data

//$service_types = serialize(array('Residential' => 're', 'Business' => 'bu', 'Mobile' => 'mo', 'Internet Fax' => 'ifa', 'Hosted PBX' => 'pbx', 'SIP Trunking' => 'sip', 'Call Center' => 'cc'));
//$service_descriptions = serialize(array('Preface title' => 'pti', 'Preface text' => 'pte', 'Basic info title' => 'biti', 'Basic info text' => 'bite', 'Special notes title' => 'snti', 'Special notes text' => 'snte', 'Money Back Guarentee' => 'mbg'));
//$fee_types = serialize(array('Monthly fees' => array('mon', '$'), 'Setup fees' => array('set', ''), 'Shipping fees' => array('shp', ''), 'Cancellation fees' => array('can', '$'), 'Long distance fees' => array('lng', ''), 'Other fees' => array('oth', '') ));
      

//$service_types = serialize(array('re' => 'Residential', 'bu' => 'Business', 'smbv' => 'Small Business', 'eb' => 'Enterprise Business', 'mb' => 'Midsize Business', 'mo' => 'Mobile', 'ifa' => 'Internet Fax', 'pbx' => 'Hosted PBX', 'sip' => 'SIP Trunking', 'cc' => 'Call Center', 're_ca' => 'Residential Canada', 'bu_ca' => 'Business Canada'));
//$service_types = serialize(array('pbx' => 'Hosted PBX', 'sip' => 'SIP Trunking', 're' => 'Residential', 'bu' => 'Business', 'smbv' => 'Small Business', 'eb' => 'Enterprise Business', 'mb' => 'Midsize Business'));
$service_types = serialize(array(/*'smbv' => 'Small Business', */'re' => 'Residential', 'bu' => 'Business', /*'mo' => 'Mobile',*/ 'ifa' => 'Internet Fax', 'pbx' => 'Virtual/Cloud PBX', /*'sip' => 'SIP Trunking',*/ /*'cc' => 'Call Center', 're_ca' => 'Residential Canada', 'bu_ca' => 'Business Canada'*/));


$service_descriptions = serialize(array('pti' => 'Preface title', 'pte' => 'Preface text', 'biti' => 'Basic info title', 'bite' => 'Basic info text', 'snti' => 'Special notes title', 'snte' => 'Special notes text', 'mbg' => 'Money Back Guarentee', 'mf' => 'Main Features', 'vr-y' => 'Video Review (YouTube video ID)'));
$fee_types = serialize(array('mon' => array('Monthly fees', '$'), 'set' => array('Setup fees', ''), 'shp' => array('Shipping fees', ''), 'can' => array('Cancellation fees', '$'), 'lng' => array('Long distance fees', ''), 'oth' => array('Other fees', '') ));

define('SERVICE_TYPES', $service_types);
define('SERVICE_DESCRIPTIONS', $service_descriptions);
define('FEE_TYPES', $fee_types);
