<?php
/**
 * @package     151st.Site
 * @subpackage  Templates.151st.mod_breadcrumbs
 *
 * @copyright   Copyright (C) 2014 151st Freedom Fighters. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 *
 * Based on v2.5.17
 */

defined('_JEXEC') or die;

?>

<ul class="breadcrumb<?php echo $moduleclass_sfx; ?>">
	<?php
	if ($params->get('showHere', 1))
	{
		echo '<li><span class="glyphicon glyphicon-map-marker hasTooltip" title="' . JText::_('MOD_BREADCRUMBS_HERE') . '"></span></li>';
	}

	// Get rid of duplicated entries on trail including home page when using multilanguage
	for ($i = 0; $i < $count; $i++)
	{
		if ($i == 1 && !empty($list[$i]->link) && !empty($list[$i - 1]->link) && $list[$i]->link == $list[$i - 1]->link)
		{
			unset($list[$i]);
		}
	}

	// Find last and penultimate items in breadcrumbs list
	end($list);
	$last_item_key = key($list);
	prev($list);
	$penult_item_key = key($list);

	// Make a link if not the last item in the breadcrumbs
	$show_last = $params->get('showLast', 1);

	// Generate the trail
	foreach ($list as $key => $item) :
	if ($key != $last_item_key)
	{
		// Render all but last item - along with separator
		echo '<li>';
		if (!empty($item->link))
		{
			echo '<a href="' . $item->link . '" class="pathway">' . $item->name . '</a>';
		}
		else
		{
			echo '<span>' . $item->name . '</span>';
		}

		echo '</li>';
	}
	elseif ($show_last)
	{
		// Render last item if reqd.
		echo '<li class="active">';
		echo '<span>' . $item->name . '</span>';
		echo '</li>';
	}
	endforeach; ?>
</ul>
