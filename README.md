twitterJSONMarge
================

twitter JSON file marge script


## Quick Start

    <?php
	require_once('./twitterJSONMarge.php');
	mb_internal_encoding('UTF-8');
	ini_set('memory_limit','-1');
	ini_set('max_execution_time',0);
	new twitterJSONMarge('./json/', './marge.json');

