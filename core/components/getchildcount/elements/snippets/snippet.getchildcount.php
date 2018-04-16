<?php
/**
 * number of child resource documents in MODX Revo
 * This algorithm taken from https://github.com/
 * 
 * @var array $scriptProperties
 */
//if (empty($input)) { return false; }
//if (!empty($options) && $options = $modx->fromJSON($options)) { $scriptProperties = array_merge($scriptProperties, $options); }

//Connect our functions
require_once(MODX_CORE_PATH . 'components/getchildcount/include/declension.php');
$modx->lexicon->load('getchildcount:default');

//if (!empty($scriptProperties['dateNow']) && $delta > 0) {}

if (empty($parent))     {$parent = $modx->resource->id;}    //id resource for counting, if not then set to the current resource
if (empty($depth))      {$depth = 0;}                       //depth of nesting, if not, then make it equal to 0 
if (empty($deleted))    {$deleted = false;}                 //deleted, if not, then make it equal to 0 
if (empty($published))  {$published = true;}                //published, if not, then we make it equal to 1 

$pids = array_merge(array($parent), $modx->getChildIds($parent,$depth));
$ids = array();
$criteria = array(
    'parent:IN' => $pids,
);
// get an array of database field names 'modx_site_content'
$columns = getColumns($table_prefix.'site_content');

//compact — Creates an array containing the variable names and their values, Any unset strings will simply be skipped.
//that is, only the variables transferred to the snippet will remain in the array (Name => Value)
$result = compact($columns);
//print_r($result);


foreach ($result as $key => $value) { //echo "$key => $value, ";
    // if the variable is not empty and its name is not 'parent'
    if ($value!='' and $key!='parent' and $key!='toPlaceholder') { 
        //add to array to the filter array key => value for selection
        $criteria += [$key=>$value]; 
    }
}

/*if (!empty($deleted))   { $criteria += ['deleted'=>$deleted];   }   // if there is a variable $deleted then add to the filter the filter by template
if (!empty($published)) { $criteria += ['published'=>$published]; } // if there is a variable $published then add to the filter the filter by template
if (!empty($template))  { $criteria += ['template'=>$template]; }   // if there is a variable $template then add to the filter the filter by template
if (!empty($isfolder))  { $criteria += ['isfolder'=>$isfolder]; }   // if there is a variable $isfolder then add to the filter the filter by template
if (!empty($class_key)) { $criteria += ['class_key'=>$class_key]; } // if there is a variable $class_key then add to the filter the filter by template*/

$q = $modx->newQuery('modResource');
$q->where($criteria);
$q->select('`modResource`.`id`');
if ($q->prepare() && $q->stmt->execute()) {
	$ids = $q->stmt->fetchAll(PDO::FETCH_COLUMN);
}

if ($toPlaceholder=='')  { return count($ids);                     // if there is no variable $placeholder then return the number of records found
} else { $modx->setPlaceholder($toPlaceholder,count($ids)); }      // if there is a value for the placeholder (its name in the variable $placeholder) the number of entries