<?php
use yii\helpers\Html;
?>
<div class="geo-tree" data-type="region">

	<?php echo $form->field($model, 'all_regions')->checkbox(['class' => 'select-all', 'template' => '{input}{label}{error}']); ?>

	<?php $field_names = ['region_ids', 'all_destinations', 'destination_ids', 'all_locations', 'location_ids']; ?>

	<?php foreach ($field_names as $field_name): ?>

		<?php echo Html::hiddenInput(Html::getInputName($model, $field_name), ''); ?>
	
	<?php endforeach; ?>

	<ul>

	<?php foreach ($model->geoTreeInfo['regions'] as $region): ?>

		<li>
			<div>
				<span class="toggle-item" data-type="region" data-id="<?php echo $region->id; ?>">[+]</span>
				<span class="icon-region">[R]</span>
				<span>
					<?php echo Html::activeCheckbox($model, 'region_ids[]', [
						'class' => 'select-item',
						'data-type' => 'region',
						'data-id' => $region->id,
						'value' => $region->id,
						'label' => Html::encode($region->name)
					]); ?>
				</span>
			</div>

			<div class="children" data-type="destination" data-by="region" data-id="<?php echo $region->id; ?>" style="display: none;">

				<span>
					<?php echo Html::activeCheckbox($model, 'all_destinations[]', [
						'class' => 'select-all',
						'data-by' => 'region',
						'data-id' => $region->id,
						'value' => $region->id,
						'label' => 'All destinations and locations in ' . Html::encode($region->name)
					]); ?>
				</span>

				<?php if (!empty($model->geoTreeInfo['child_ids']['by_region'][$region->id])): ?>

					<ul>

					<?php foreach ($model->geoTreeInfo['child_ids']['by_region'][$region->id] as $destination_id): ?>

						<li>
							<div>
								<span class="toggle-item" data-type="destination" data-id="<?php echo $destination_id; ?>">[+]</span>
								<span class="icon-destination">[D]</span>
								<span>
									<?php echo Html::activeCheckbox($model, 'destination_ids[]', [
										'class' => 'select-item',
										'data-type' => 'destination',
										'data-id' => $destination_id,
										'value' => $destination_id,
										'label' =>Html::encode($model->geoTreeInfo['destinations'][$destination_id]->name)
									]); ?>
								</span>
							</div>

							<div class="children" data-type="location" data-by="destination" data-id="<?php echo $destination_id; ?>" style="display: none;">

								<span>
									<?php echo Html::activeCheckbox($model, 'all_locations[]', [
										'class' => 'select-all',
										'data-by' => 'destination',
										'data-id' => $destination_id,
										'value' => $destination_id,
										'label' => 'All locations in ' . Html::encode($model->geoTreeInfo['destinations'][$destination_id]->name)
									]); ?>
								</span>

								<?php if (!empty($model->geoTreeInfo['child_ids']['by_destination'][$destination_id])): ?>

									<ul>

									<?php foreach ($model->geoTreeInfo['child_ids']['by_destination'][$destination_id] as $location_id): ?>

										<li>
											<div>
												<span class="icon-location">[L]</span>
												<span>
													<?php echo Html::activeCheckbox($model, 'location_ids[]', [
														'class' => 'select-item',
														'data-type' => 'location',
														'data-id' => $location_id,
														'value' => $location_id,
														'label' => Html::encode($model->geoTreeInfo['locations'][$location_id]->name)
													]); ?>
												</span>
											</div>
										</li>

									<?php endforeach; ?>

									</ul>

								<?php endif; ?>

							</div>

						</li>

					<?php endforeach; ?>

					</ul>

				<?php endif; ?>

			</div>

		</li>
	
	<?php endforeach; ?>

	</ul>

</div>

<style>
.geo-tree {
	list-style-type: none;
	margin: 0;
	padding: 0;
}
.geo-tree .children {
	padding-left: 16px;
}
</style>

<?php

$js = <<<EOT
$(function() {

	$('.geo-tree .toggle-item').on('click', function() {
		toggleChildren($(this).attr('data-type'), $(this).attr('data-id'));
	});

	$('.geo-tree .select-item').on('change', function() {
		var type = $(this).attr('data-type');
		var id = $(this).attr('data-id');
		if (this.checked) {
			onCheckItem(type, id);
		} else {
			onUncheckItem(type, id);
		}
	});

	$('.geo-tree .select-all').on('change', function() {
		var by = $(this).attr('data-by');
		if (by !== undefined) {
			var id = $(this).attr('data-id');
			if (this.checked) {
				onCheckAll(by, id);
			} else {
				onUncheckAll(by, id);
			}
		} else {
			if (this.checked) {
				onCheckAll(false);
			} else {
				onUncheckAll(false);
			}
		}
	});

	function changeItem(type, id, checked, caller) {
//		getItemElement(type, id).prop('checked', checked);

		itemElement = getItemElement(type, id);
		if (itemElement.prop('checked') == checked) return;
		itemElement.prop('checked', checked);

		if (checked) {
			onCheckItem(type, id, caller);
		} else {
			onUncheckItem(type, id, caller);
		}
	}

	function onCheckItem(type, id, caller = false) {
		toggleChildren(type, id, 'expand');

//		if (caller === false) {
//			changeAll(type, id, true, 'onCheckItem');
//		} else if (caller !== 'onCheckAll') {
//			changeAll(type, id, false, 'onCheckItem');
//		}

		if (caller === false) {
			changeAll(type, id, true, 'onCheckItem');
		}

		var data = getParentData(type, id);
		if (data !== false) {
			changeItem(data['type'], data['id'], true, 'onCheckItem');
			changeAll(data['type'], data['id'], false, 'onCheckItem');
		} else {
			changeAll(false, false, false, 'onCheckItem');
		}
	}

	function onUncheckItem(type, id, caller = false) {
		uncheckChildren(type, id);
		changeAll(type, id, false, 'onUncheckItem');
		toggleChildren(type, id, 'collapse');

		var data = getParentData(type, id);
		if (data !== false) {
			if (getItemElement(data['type'], data['id']).is(':checked') && !countCheckedChildren(data['type'], data['id'])) {
				changeAll(data['type'], data['id'], true, 'onUncheckItem');
			}
		} else {
			if (!countCheckedChildren(false)) {
				changeAll(false, false, true, 'onUncheckItem');
			}
		}				
	}

	function changeAll(by, id, checked, caller = false) {
		var selector;
		if (by !== false) {
			selector = '.geo-tree .select-all[data-by="' + by + '"][data-id="' + id + '"]';
		} else {
			selector = '.geo-tree .select-all:not([data-by])';
		}
		if ($(selector).length == 0) return;

		$(selector).prop('checked', checked);
		if (checked) {
			onCheckAll(by, id, caller);
		} else {
			onUncheckAll(by, id, caller);
		}
	}

	function onCheckAll(by, id = false, caller = false) {
		if (caller === false) {
			if (by !== false) {
				uncheckChildren(by, id);
				changeItem(by, id, true, 'onCheckAll');
			} else {
				uncheckChildren(false);
			}
		}
	}

	function onUncheckAll(by, id = false, caller = false) {
		if (caller === false) {
			if (by !== false) {
				changeItem(by, id, false, 'onUncheckAll');
			}
		}
	}

	function getItemElement(type, id) {
		return $('.geo-tree .select-item[data-type="' + type + '"][data-id="' + id + '"]');
	}

	function getParentData(type, id) {
		var wrapperElement = getItemElement(type, id).closest('.geo-tree .children');
		if (wrapperElement.length > 0) {
			return {
				type: wrapperElement.attr('data-by'),
				id: wrapperElement.attr('data-id')
			};
		} else {
			return false;
		}
	}

	function countCheckedChildren(by, id = false) {
		var selector;
		if (by !== false) {
			selector = '.geo-tree .children[data-by="' + by + '"][data-id="' + id + '"]';
		} else {
			selector = '.geo-tree';
		}
		if ($(selector).length == 0) return;

		return $(selector + ' .select-item[data-type="' + $(selector).attr('data-type') + '"]:checked').length;
	}

	function uncheckChildren(by, id = false) {
		var selector;
		if (by !== false) {
			selector = '.geo-tree .children[data-by="' + by + '"][data-id="' + id + '"]';
		} else {
			selector = '.geo-tree';
		}
		if ($(selector).length == 0) return;

		$(selector + ' .select-item[data-type="' + $(selector).attr('data-type') + '"]').each(function() {
			changeItem($(this).attr('data-type'), $(this).attr('data-id'), false, 'uncheckChildren');
		});
	}

	function toggleChildren(by, id, force = false) {
		var selector = '.geo-tree .children[data-by="' + by + '"][data-id="' + id + '"]';
		if (force !== false) {
			if (force == 'expand') {
				if ($(selector).is(':visible')) {
					return;
				}
			} else if (!$(selector).is(':visible')) {
				return;
			}
		}
		$(selector).toggle();
		var sign = ($(selector).is(':visible')) ? '[-]' : '[+]';
		$('.geo-tree .toggle-item[data-type="' + by + '"][data-id="' + id + '"]').html(sign);
	}		

});
EOT;

$this->registerJS($js);
