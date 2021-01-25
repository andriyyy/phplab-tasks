<?php
/**
 * The $input variable contains an array of digits
 * Return an array which will contain the same digits but repetitive by its value
 * without changing the order.
 * Example: [1,3,2] => [1,3,3,3,2,2]
 *
 * @param  array  $input
 * @return array
 */
function repeatArrayValues(array $input)
{
    $arr = [];
    foreach ($input as $max)
    {
        for ($i = 0;$i < $max;$i++)
        {
            $arr[] = $max;
        }
    }
    return $arr;
}

/**
 * The $input variable contains an array of digits
 * Return the lowest unique value or 0 if there is no unique values or array is empty.
 * Example: [1, 2, 3, 2, 1, 5, 6] => 3
 *
 * @param  array  $input
 * @return int
 */
function getUniqueValue(array $input)
{
    $arr = [];
    foreach ($input as $item)
    {
        $arr[$item] = isset($arr[$item]) ? $arr[$item] + 1 : 1;
    }
    $minArr = [];
    foreach ($arr as $key => $item)
    {
        if ($item == 1)
        {
            $minArr[] = $key;
        }

    }
    return !empty($minArr) ? min($minArr) : 0;
}

/**
 * The $input variable contains an array of arrays
 * Each sub array has keys: name (contains strings), tags (contains array of strings)
 * Return the list of names grouped by tags
 * !!! The 'names' in returned array must be sorted ascending.
 *
 * Example:
 * [
 *  ['name' => 'potato', 'tags' => ['vegetable', 'yellow']],
 *  ['name' => 'apple', 'tags' => ['fruit', 'green']],
 *  ['name' => 'orange', 'tags' => ['fruit', 'yellow']],
 * ]
 *
 * Should be transformed into:
 * [
 *  'fruit' => ['apple', 'orange'],
 *  'green' => ['apple'],
 *  'vegetable' => ['potato'],
 *  'yellow' => ['orange', 'potato'],
 * ]
 *
 * @param  array  $input
 * @return array
 */

function groupByTag(array $input)
{
    $arr = [];

    foreach ($input as $item)
    {
        foreach ($item["tags"] as $tag)
        {
            if (!isset($arr[$tag]))
            {
                $arr[$tag] = [];
            }
            array_push($arr[$tag], $item["name"]);

        }

    }
    
    $arrSorted = [];

    foreach ($arr as $key => $item)
    {
        sort($item);
        $arrSorted[$key] = $item;

    }
    return $arrSorted;
}

