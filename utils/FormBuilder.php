<?php

/**
 * Dynamic Form Builder Utility for Bootstrap 4
 * Enhanced for rounded inputs, improved dropdown visibility, and multi-column layouts
 */

class FormBuilder
{
    /**
     * Renders an individual form field based on its configuration
     */
    public static function render_form_field($field, $errors = [], $old_input = [])
    {
        $name = $field['field_name'];
        $label = $field['field_label'];
        $type = $field['field_type'];
        $required = $field['is_required'] ? 'required' : '';

        $options = [];
        if (!empty($field['options'])) {
            if (is_array($field['options'])) {
                $options = $field['options'];
            } else {
                $options = json_decode($field['options'], true) ?: [];
            }
        }

        // Clean column control based on field semantic set; phone always full width
        $half_width_fields = ['first_name', 'last_name', 'lastname', 'middle_name', 'email'];
        if (in_array(strtolower($name), $half_width_fields, true)) {
            $width_class = 'col-md-6';
        } else {
            $width_class = 'col-12';
        }

        $html = '<div class="' . $width_class . ' mb-3">';
        $html .= '<div class="form-group">';
        $html .= '<label for="' . $name . '" class="form-label font-weight-bold" style="color: #444; margin-bottom: 8px; display: block;">' . htmlspecialchars($label);
        if ($required) {
            $html .= ' <span class="text-danger">*</span>';
        }
        $html .= '</label>';

        // Base style for all text-based inputs and selects
        $has_error = isset($errors[$name]);
        $border_color = $has_error ? '#dc3545' : '#ddd';
        $input_style = "border-radius: 50px; padding: 15px 20px; border: 1px solid $border_color; min-height: 52px; transition: all 0.3s ease;";
        $select_style = "border-radius: 50px; padding: 15px 20px; border: 1px solid $border_color; min-height: 52px; transition: all 0.3s ease;";
        $textarea_style = "border-radius: 20px; padding: 15px 20px; border: 1px solid $border_color; min-height: 140px; transition: all 0.3s ease;";

        $value = $old_input[$name] ?? '';

        switch ($type) {
            case 'text':
            case 'email':
            case 'number':
                $html .= '<input type="' . $type . '" id="' . $name . '" name="' . $name . '" class="form-control ' . ($has_error ? 'is-invalid' : '') . '" style="' . $input_style . '" placeholder="Enter ' . strtolower(htmlspecialchars($label)) . '" value="' . htmlspecialchars($value) . '" ' . $required . '>';
                break;

            case 'textarea':
                $html .= '<textarea id="' . $name . '" name="' . $name . '" class="form-control ' . ($has_error ? 'is-invalid' : '') . '" rows="4" style="' . $textarea_style . '" placeholder="Enter ' . strtolower(htmlspecialchars($label)) . '" ' . $required . '>' . htmlspecialchars($value) . '</textarea>';
                break;

            case 'select':
                // Special handling for local_government examples if options are null
                if ($name === 'local_government' && empty($options)) {
                    $options = ['Kano Municipal', 'Tarauni', 'Nassarawa', 'Gwale', 'Fagge'];
                }
                $html .= '<select id="' . $name . '" name="' . $name . '" class="form-control custom-select ' . ($has_error ? 'is-invalid' : '') . '" style="' . $select_style . ' height: auto; -webkit-appearance: none;" ' . $required . '>';
                $html .= '<option value="">-- Select ' . htmlspecialchars($label) . ' --</option>';
                if (!empty($options)) {
                    foreach ($options as $option) {
                        $selected = ($value == $option) ? 'selected' : '';
                        $html .= '<option value="' . htmlspecialchars($option) . '" ' . $selected . '>' . htmlspecialchars($option) . '</option>';
                    }
                }
                $html .= '</select>';
                break;

            case 'file':
                $html .= '<div style="position: relative; border-radius: 50px; overflow: hidden; border: 1px solid #ddd; background: #fff;">';
                $html .= '<input type="file" id="' . $name . '" name="' . $name . '" class="custom-file-input" style="position: absolute; opacity: 0; width: 100%; height: 100%; cursor: pointer;" ' . $required . '>';
                $html .= '<label for="' . $name . '" style="display: flex; align-items: center; justify-content: space-between; padding: 15px 20px; min-height: 52px; cursor: pointer; background: #fff; margin: 0;">';
                $html .= '<span class="file-name-text" style="color: #999; font-weight: normal;">Choose file</span>';
                $html .= '<span style="background: #f48221; color: #fff; padding: 8px 18px; border-radius: 20px; font-weight: 600; font-size: 0.9rem; white-space: nowrap; margin-left: 10px;">Select</span>';
                $html .= '</label>';
                $html .= '</div>';
                $html .= '<small class="form-text text-muted" style="display: block; margin-top: 8px;">Max file size: 5MB. Allowed: JPG, PNG, PDF.</small>';
                break;

            case 'radio':
                $html .= '<div class="d-flex flex-wrap mt-1">';
                foreach ($options as $idx => $option) {
                    $html .= '<div class="custom-control custom-radio mr-3">';
                    $html .= '<input class="custom-control-input" type="radio" name="' . $name . '" id="' . $name . '_' . $idx . '" value="' . htmlspecialchars($option) . '" ' . ($idx === 0 && $required ? 'required' : '') . '>';
                    $html .= '<label class="custom-control-label" for="' . $name . '_' . $idx . '">' . htmlspecialchars($option) . '</label>';
                    $html .= '</div>';
                }
                $html .= '</div>';
                break;

            case 'checkbox':
                $html .= '<div class="d-flex flex-wrap mt-1">';
                foreach ($options as $idx => $option) {
                    $html .= '<div class="custom-control custom-checkbox mr-3">';
                    $html .= '<input class="custom-control-input" type="checkbox" name="' . $name . '[]" id="' . $name . '_' . $idx . '" value="' . htmlspecialchars($option) . '">';
                    $html .= '<label class="custom-control-label" for="' . $name . '_' . $idx . '">' . htmlspecialchars($option) . '</label>';
                    $html .= '</div>';
                }
                $html .= '</div>';
                break;
        }

        if ($has_error) {
            $html .= '<div class="invalid-feedback d-block ml-3 mt-1" style="font-size: 0.85rem; font-weight: 500;">' . $errors[$name] . '</div>';
        }

        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

    /**
     * Validates dynamic form inputs based on field definitions
     */
    public static function validate_dynamic_inputs($fields, $post_data, $files_data)
    {
        $errors = [];
        $valid_data = [];

        foreach ($fields as $field) {
            $name = $field['field_name'];
            $label = $field['field_label'];
            $type = $field['field_type'];
            $required = $field['is_required'];

            if ($type === 'file') {
                if (isset($files_data[$name]) && $files_data[$name]['error'] === UPLOAD_ERR_OK) {
                    $valid_data[$name] = [
                        'name' => $files_data[$name]['name'],
                        'type' => $files_data[$name]['type'],
                        'size' => $files_data[$name]['size'],
                        'tmp_name' => $files_data[$name]['tmp_name']
                    ];
                } elseif ($required) {
                    $errors[$name] = $label . " is required.";
                }
            } else {
                $value = isset($post_data[$name]) ? $post_data[$name] : null;

                if ($required && (empty($value) && $value !== '0')) {
                    $errors[$name] = $label . " is required.";
                } else {
                    if ($type === 'email' && !empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $errors[$name] = "Please enter a valid email address.";
                    }
                    $valid_data[$name] = is_array($value) ? array_map('htmlspecialchars', $value) : htmlspecialchars($value);
                }
            }
        }

        return ['errors' => $errors, 'data' => $valid_data];
    }
}
?>