<?php

/**
 * Dynamic Form Builder Utility for Bootstrap 4
 * Enhanced for rounded inputs, improved dropdown visibility, and multi-column layouts
 */

/**
 * Renders an individual form field based on its configuration
 */
function render_form_field($field) {
    $name = $field['field_name'];
    $label = $field['field_label'];
    $type = $field['field_type'];
    $required = $field['is_required'] ? 'required' : '';
    $options = !empty($field['options']) ? json_decode($field['options'], true) : [];
    $width_class = isset($field['field_width']) && $field['field_width'] === 'half' ? 'col-md-6' : 'col-12';

    $html = '<div class="' . $width_class . ' mb-3">';
    $html .= '<div class="form-group">';
    $html .= '<label for="' . $name . '" class="form-label font-weight-bold" style="color: #444; margin-bottom: 8px; display: block;">' . htmlspecialchars($label);
    if ($required) {
        $html .= ' <span class="text-danger">*</span>';
    }
    $html .= '</label>';

    // Base style for all text-based inputs and selects
    $input_style = 'border-radius: 50px; padding: 12px 20px; border: 1px solid #ddd; transition: all 0.3s ease;';
    $textarea_style = 'border-radius: 20px; padding: 15px 20px; border: 1px solid #ddd; transition: all 0.3s ease;';

    switch ($type) {
        case 'text':
        case 'email':
        case 'number':
            $html .= '<input type="' . $type . '" id="' . $name . '" name="' . $name . '" class="form-control" style="' . $input_style . '" placeholder="Enter ' . strtolower(htmlspecialchars($label)) . '" ' . $required . '>';
            break;

        case 'textarea':
            $html .= '<textarea id="' . $name . '" name="' . $name . '" class="form-control" rows="4" style="' . $textarea_style . '" placeholder="Enter ' . strtolower(htmlspecialchars($label)) . '" ' . $required . '></textarea>';
            break;

        case 'select':
            $html .= '<select id="' . $name . '" name="' . $name . '" class="form-control custom-select" style="' . $input_style . ' height: auto; -webkit-appearance: none;" ' . $required . '>';
            $html .= '<option value="">-- Select ' . htmlspecialchars($label) . ' --</option>';
            foreach ($options as $option) {
                $html .= '<option value="' . htmlspecialchars($option) . '">' . htmlspecialchars($option) . '</option>';
            }
            $html .= '</select>';
            break;

        case 'file':
            $html .= '<div class="custom-file" style="border-radius: 50px; overflow: hidden;">';
            $html .= '<input type="file" id="' . $name . '" name="' . $name . '" class="custom-file-input" ' . $required . '>';
            $html .= '<label class="custom-file-label" for="' . $name . '" style="border-radius: 50px; padding: 12px 20px; height: auto;">Choose file</label>';
            $html .= '</div>';
            $html .= '<small class="form-text text-muted mt-1">Max file size: 5MB. Allowed: JPG, PNG, PDF.</small>';
            break;

        case 'radio':
            $html .= '<div class="d-flex flex-wrap gap-3 mt-1">';
            foreach ($options as $idx => $option) {
                $html .= '<div class="custom-control custom-radio mr-3">';
                $html .= '<input class="custom-control-input" type="radio" name="' . $name . '" id="' . $name . '_' . $idx . '" value="' . htmlspecialchars($option) . '" ' . ($idx === 0 && $required ? 'required' : '') . '>';
                $html .= '<label class="custom-control-label" for="' . $name . '_' . $idx . '">' . htmlspecialchars($option) . '</label>';
                $html .= '</div>';
            }
            $html .= '</div>';
            break;

        case 'checkbox':
            $html .= '<div class="d-flex flex-wrap gap-3 mt-1">';
            foreach ($options as $idx => $option) {
                $html .= '<div class="custom-control custom-checkbox mr-3">';
                $html .= '<input class="custom-control-input" type="checkbox" name="' . $name . '[]" id="' . $name . '_' . $idx . '" value="' . htmlspecialchars($option) . '">';
                $html .= '<label class="custom-control-label" for="' . $name . '_' . $idx . '">' . htmlspecialchars($option) . '</label>';
                $html .= '</div>';
            }
            $html .= '</div>';
            break;
    }

    $html .= '</div>';
    $html .= '</div>';
    return $html;
}

/**
 * Validates dynamic form inputs based on field definitions
 */
function validate_dynamic_inputs($fields, $post_data, $files_data) {
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
                $errors[] = $label . " is required.";
            }
        } else {
            $value = isset($post_data[$name]) ? $post_data[$name] : null;

            if ($required && (empty($value) && $value !== '0')) {
                $errors[] = $label . " is required.";
            } else {
                $valid_data[$name] = is_array($value) ? array_map('htmlspecialchars', $value) : htmlspecialchars($value);
            }
        }
    }

    return ['errors' => $errors, 'data' => $valid_data];
}
