<?php

/**
 * Dynamic Form Builder Utility for Bootstrap 4
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

    $html = '<div class="form-group">';
    $html .= '<label for="' . $name . '">' . htmlspecialchars($label);
    if ($required) {
        $html .= ' <span class="text-danger">*</span>';
    }
    $html .= '</label>';

    switch ($type) {
        case 'text':
        case 'email':
        case 'number':
            $html .= '<input type="' . $type . '" id="' . $name . '" name="' . $name . '" class="form-control" ' . $required . '>';
            break;

        case 'textarea':
            $html .= '<textarea id="' . $name . '" name="' . $name . '" class="form-control" rows="4" ' . $required . '></textarea>';
            break;

        case 'select':
            $html .= '<select id="' . $name . '" name="' . $name . '" class="form-control" ' . $required . '>';
            $html .= '<option value="">-- Select ' . htmlspecialchars($label) . ' --</option>';
            foreach ($options as $option) {
                $html .= '<option value="' . htmlspecialchars($option) . '">' . htmlspecialchars($option) . '</option>';
            }
            $html .= '</select>';
            break;

        case 'file':
            $html .= '<input type="file" id="' . $name . '" name="' . $name . '" class="form-control-file" ' . $required . '>';
            $html .= '<small class="form-text text-muted">Max file size: 5MB. Allowed: JPG, PNG, PDF.</small>';
            break;

        case 'radio':
            foreach ($options as $idx => $option) {
                $html .= '<div class="form-check">';
                $html .= '<input class="form-check-input" type="radio" name="' . $name . '" id="' . $name . '_' . $idx . '" value="' . htmlspecialchars($option) . '" ' . ($idx === 0 && $required ? 'required' : '') . '>';
                $html .= '<label class="form-check-label" for="' . $name . '_' . $idx . '">' . htmlspecialchars($option) . '</label>';
                $html .= '</div>';
            }
            break;

        case 'checkbox':
            foreach ($options as $idx => $option) {
                $html .= '<div class="form-check">';
                $html .= '<input class="form-check-input" type="checkbox" name="' . $name . '[]" id="' . $name . '_' . $idx . '" value="' . htmlspecialchars($option) . '">';
                $html .= '<label class="form-check-label" for="' . $name . '_' . $idx . '">' . htmlspecialchars($option) . '</label>';
                $html .= '</div>';
            }
            break;
    }

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
                // File validation logic would go here
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
