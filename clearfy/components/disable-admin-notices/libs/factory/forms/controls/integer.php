<?php

	/**
	 * Integer Control
	 * Main options:
	 *  name         => a name of the control
	 *  way          => Тип значения 'slider' - слайдер, 'checkbox-slider' - чекбокс активирует слайдер, по умолчанию input
	 *  checkbox     => Указывается если, 'way' имеет значение 'checkbox-slider'
	 *                  Пример:
	 *                      array(
	 *                          'on'  => __('Show shadow', 'bizpanda'),
	 *                          'off' => __('Hide shadow', 'bizpanda'),
	 *                      )
	 *  title        => Заголовок контрола
	 *  slider-title => Заголовок слайдера( Только если 'way' имеет значение 'checkbox-slider' )
	 *  range        => Диапазон значений, указывается если 'way' имеет значение 'slider' или 'checkbox-slider'
	 *                  Пример:  array(0,100)
	 *  units        => Единицы измерения(px,pt,em,%)
	 *  isActive     => Включение, отключение поля
	 *  value        => a value to show in the control
	 *  default      => a default value of the control if the "value" option is not specified
	 *
	 * @author Alex Kovalev <alex.kovalevv@gmail.com>
	 * @copyright (c) 2018, Webcraftic Ltd
	 *
	 * @package factory-forms
	 * @since 1.0.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	if( !class_exists('Wbcr_FactoryForms480_IntegerControl') ) {

		class Wbcr_FactoryForms480_IntegerControl extends Wbcr_FactoryForms480_Control {

			public $type = 'integer';

			/**
			 * Converting string to integer.
			 *
			 * @since 1.0.0
			 * @return integer
			 */
			public function html()
			{

				$name = $this->getNameOnForm();
				$value = esc_attr($this->getValue());
				$step = 1;
				$range = $checkbox = array();
				$is_active = $this->getOption('isActive', 1);
				$unit = esc_attr($this->getOption('units'));

				$way = $this->getOption('way');

				if( empty($way) ) {
					$way = 'text';
				}

				$has_slider = false;

				if( in_array($way, array('slider', 'checkbox-slider')) ) {
					$range = $this->getOption('range', array(0, 99));
					$slider_title = $this->getOption('slider-title');
					$checkbox = $this->getOption('checkbox');
					$step = $this->getOption('step', 1);
					$has_slider = true;
				}

				$this->addCssClass('factory-way-' . $way);

				if( $has_slider ) {
					$this->addCssClass('factory-has-slider');
				}
				?>

				<div <?php $this->attrs() ?>>
					<?php if( $has_slider ) { ?>

						<?php if( 'checkbox-slider' == $way ) { ?>

							<div>
								<label for="<?php echo esc_attr($name); ?>_checker"><?php echo $is_active
										? $checkbox['off']
										: $checkbox['on']; ?></label><br>
								<input type="checkbox" id="<?php echo esc_attr($name); ?>_checker" class="factory-checkbox" name="<?php echo esc_attr($name); ?>_checker" <?php echo $is_active
									? 'checked'
									: '' ?>>
							</div>

						<?php } ?>

						<div
							data-units="<?php echo esc_attr($unit); ?>"
							data-range-start="<?php echo esc_attr($range[0]); ?>"
							data-range-end="<?php echo esc_attr($range[1]); ?>"
							data-step="<?php echo esc_attr($step) ?>"
							<?php echo !$is_active
								? ' style="display:none;"'
								: '' ?>
							class="factory-slider-container factory-slider-container-<?php echo esc_attr($name); ?>">
							<?php if( !empty($slider_title) ): ?>
								<label class="factory-title">
									<?php echo esc_html($this->getOption('slider-title')); ?>
								</label>
							<?php endif; ?>

							<div class="factory-slider">
								<div class="factory-bar"></div>
                    <span class="factory-visible-value">
                        <?php echo esc_html($value); ?><?php echo esc_html($unit); ?>
                    </span>
							</div>
							<input type="hidden" name="<?php echo esc_attr($name); ?>" class="factory-result" value="<?php echo esc_attr($value); ?>"/>
						</div>

					<?php } else { ?>

						<input type="number" id="<?php echo esc_attr($name); ?>" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr($value); ?>" class="factory-input-text"/>
						<span class="factory-units"><?php echo esc_html($unit); ?></span>

					<?php } ?>
				</div><!-- .factory-integer -->
			<?php
			}

			/**
			 * Форматирует значение без единиц измерения
			 * @param string $values
			 * @param string $unit
			 * @return string
			 */
			public function valueFormatWithoutUnit($values, $unit)
			{
				if( !is_numeric($values) ) {
					return str_replace($unit, '', $values);
				} else {
					return $values;
				}
			}

			/**
			 * Форматирует значение c единицами измерения
			 * @param string $values
			 * @param string $unit
			 * @return string
			 */
			public function valueFormatWithUnit($values, $unit)
			{
				if( is_numeric($values) ) {
					return $values . $unit;
				} else {
					return $values;
				}
			}
		}
	}