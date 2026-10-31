<?php

/**
 * Modern Dynamic Form Builder Utility for Spider Tech
 * High-craft, human-designed form generation from database specifications
 */

class FormBuilder
{
    /**
     * Maps field names/semantics to clean Material Symbols icons
     */
    private static function get_field_icon($name, $type)
    {
        $name = strtolower($name);

        if (str_contains($name, 'email')) return 'mail';
        if (str_contains($name, 'phone') || str_contains($name, 'tel') || str_contains($name, 'mobile')) return 'call';
        if (str_contains($name, 'name')) return 'person';
        if (str_contains($name, 'birth') || str_contains($name, 'date') || str_contains($name, 'age')) return 'calendar_today';
        if (str_contains($name, 'gender') || str_contains($name, 'sex')) return 'wc';
        if (str_contains($name, 'school') || str_contains($name, 'class') || str_contains($name, 'grade') || str_contains($name, 'qualif') || str_contains($name, 'degree')) return 'school';
        if (str_contains($name, 'state') || str_contains($name, 'government') || str_contains($name, 'city') || str_contains($name, 'address') || str_contains($name, 'location')) return 'location_on';
        if (str_contains($name, 'business') || str_contains($name, 'company') || str_contains($name, 'org') || str_contains($name, 'sector')) return 'domain';
        if (str_contains($name, 'experience') || str_contains($name, 'year')) return 'history_edu';
        if (str_contains($name, 'laptop') || str_contains($name, 'computer')) return 'laptop_mac';
        if (str_contains($name, 'code') || str_contains($name, 'programming')) return 'terminal';
        if (str_contains($name, 'parent') || str_contains($name, 'guardian') || str_contains($name, 'relat')) return 'supervisor_account';
        if (str_contains($name, 'file') || str_contains($name, 'upload') || str_contains($name, 'proof') || str_contains($name, 'cert') || str_contains($name, 'id')) return 'attach_file';
        if ($type === 'select') return 'list';
        if ($type === 'number') return 'tag';

        return 'edit_note';
    }

    /**
     * Renders an individual form field based on its configuration
     */
    public static function render_form_field($field, $errors = [], $old_input = [])
    {
        $name = $field['field_name'];
        $label = $field['field_label'];
        $type = $field['field_type'];
        $required = !empty($field['is_required']) ? 'required' : '';
        $icon = self::get_field_icon($name, $type);

        $options = [];
        if (!empty($field['options'])) {
            if (is_array($field['options'])) {
                $options = $field['options'];
            } else {
                $options = json_decode($field['options'], true) ?: [];
            }
        }

        // Intelligently calculate column width: database field_width takes precedence, followed by semantic pairing
        $width_class = 'col-12';
        if (!empty($field['field_width'])) {
            $width_class = ($field['field_width'] === 'half') ? 'col-md-6' : 'col-12';
        } else {
            $half_fields = [
                'first_name', 'last_name', 'middle_name', 'firstname', 'lastname', 'full_name',
                'email', 'email_alt', 'phone', 'phone_alt', 'phone_no',
                'age', 'gender', 'date_of_birth',
                'state_of_origin', 'local_government',
                'current_class', 'school_name',
                'parent_relationship', 'parent_phone', 'parent_email',
                'years_of_experience', 'business_type', 'business_section', 'business_stage',
                'has_laptop', 'prior_experience', 'emergency_contact_phone'
            ];
            if (in_array(strtolower($name), $half_fields, true)) {
                $width_class = 'col-md-6';
            }
        }

        $has_error = isset($errors[$name]);
        $value = $old_input[$name] ?? '';

        $html = '<div class="' . $width_class . ' mb-3 mb-md-4">';
        $html .= '<div class="form-group-modern">';
        $html .= '<label for="' . $name . '" class="form-label-modern">' . htmlspecialchars($label);
        if ($required) {
            $html .= ' <span class="req-star" title="Required">*</span>';
        }
        $html .= '</label>';

        switch ($type) {
            case 'text':
            case 'email':
            case 'number':
                $input_type = $type;
                $html .= '<div class="input-wrapper-modern ' . ($has_error ? 'has-error' : '') . '">';
                $html .= '<span class="material-symbols-outlined input-leading-icon">' . $icon . '</span>';
                $html .= '<input type="' . $input_type . '" id="' . $name . '" name="' . $name . '" class="form-control-modern ' . ($has_error ? 'is-invalid' : '') . '" placeholder="Enter ' . strtolower(htmlspecialchars($label)) . '" value="' . htmlspecialchars($value) . '" ' . $required . '>';
                $html .= '</div>';
                break;

            case 'textarea':
                $html .= '<div class="input-wrapper-modern textarea-wrapper-modern ' . ($has_error ? 'has-error' : '') . '">';
                $html .= '<textarea id="' . $name . '" name="' . $name . '" class="form-control-modern form-textarea-modern ' . ($has_error ? 'is-invalid' : '') . '" rows="3" placeholder="Enter ' . strtolower(htmlspecialchars($label)) . '" ' . $required . '>' . htmlspecialchars($value) . '</textarea>';
                $html .= '</div>';
                break;

            case 'select':
                if ($name === 'local_government' && empty($options)) {
                    $options = ['Kano Municipal', 'Tarauni', 'Nassarawa', 'Gwale', 'Fagge', 'Dala', 'Ungogo', 'Kumbotso', 'Bichi', 'Gaya', 'Rano', 'Other'];
                }
                $html .= '<div class="input-wrapper-modern select-wrapper-modern ' . ($has_error ? 'has-error' : '') . '">';
                $html .= '<span class="material-symbols-outlined input-leading-icon">' . $icon . '</span>';
                $html .= '<select id="' . $name . '" name="' . $name . '" class="form-control-modern form-select-modern ' . ($has_error ? 'is-invalid' : '') . '" ' . $required . '>';
                $html .= '<option value="">Select ' . htmlspecialchars($label) . '</option>';
                if (!empty($options)) {
                    foreach ($options as $option) {
                        $selected = ($value == $option) ? 'selected' : '';
                        $html .= '<option value="' . htmlspecialchars($option) . '" ' . $selected . '>' . htmlspecialchars($option) . '</option>';
                    }
                }
                $html .= '</select>';
                $html .= '<span class="material-symbols-outlined select-chevron-icon">expand_more</span>';
                $html .= '</div>';
                break;

            case 'file':
                // Clean, space-efficient horizontal file attachment component
                $html .= '<div class="compact-file-upload ' . ($has_error ? 'has-error' : '') . '" data-name="' . $name . '">';
                $html .= '<input type="file" id="' . $name . '" name="' . $name . '" class="compact-file-input" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" ' . $required . '>';
                $html .= '<div class="compact-file-idle">';
                $html .= '<div class="d-flex align-items-center gap-2 min-w-0 flex-grow-1">';
                $html .= '<span class="material-symbols-outlined file-icon">attach_file</span>';
                $html .= '<span class="file-prompt-text text-truncate">Attach ' . htmlspecialchars($label) . ' <small class="text-muted">(PDF, JPG, PNG &le; 5MB)</small></span>';
                $html .= '</div>';
                $html .= '<span class="btn-compact-browse">Browse</span>';
                $html .= '</div>';
                $html .= '<div class="compact-file-active" style="display: none;">';
                $html .= '<div class="d-flex align-items-center gap-2 min-w-0 flex-grow-1 text-truncate">';
                $html .= '<span class="material-symbols-outlined file-success-icon">check_circle</span>';
                $html .= '<span class="compact-file-name text-truncate">filename.pdf</span>';
                $html .= '</div>';
                $html .= '<button type="button" class="btn-compact-clear" title="Remove attachment"><span class="material-symbols-outlined">close</span></button>';
                $html .= '</div>';
                $html .= '</div>';
                break;

            case 'radio':
                $html .= '<div class="choice-group-modern">';
                foreach ($options as $idx => $option) {
                    $optId = $name . '_' . $idx;
                    $checked = ($value == $option) ? 'checked' : '';
                    $html .= '<label class="choice-pill-modern" for="' . $optId . '">';
                    $html .= '<input type="radio" name="' . $name . '" id="' . $optId . '" value="' . htmlspecialchars($option) . '" ' . $checked . ' ' . ($idx === 0 && $required ? 'required' : '') . '>';
                    $html .= '<span class="choice-content-box">';
                    $html .= '<span class="choice-radio-bullet"></span>';
                    $html .= '<span class="choice-label-text">' . htmlspecialchars($option) . '</span>';
                    $html .= '</span>';
                    $html .= '</label>';
                }
                $html .= '</div>';
                break;

            case 'checkbox':
                $html .= '<div class="choice-group-modern">';
                foreach ($options as $idx => $option) {
                    $optId = $name . '_' . $idx;
                    $checked = (is_array($value) && in_array($option, $value)) ? 'checked' : '';
                    $html .= '<label class="choice-pill-modern" for="' . $optId . '">';
                    $html .= '<input type="checkbox" name="' . $name . '[]" id="' . $optId . '" value="' . htmlspecialchars($option) . '" ' . $checked . '>';
                    $html .= '<span class="choice-content-box">';
                    $html .= '<span class="choice-check-bullet"></span>';
                    $html .= '<span class="choice-label-text">' . htmlspecialchars($option) . '</span>';
                    $html .= '</span>';
                    $html .= '</label>';
                }
                $html .= '</div>';
                break;
        }

        if ($has_error) {
            $html .= '<div class="invalid-feedback-modern">';
            $html .= '<span class="material-symbols-outlined" style="font-size: 14px;">error</span>';
            $html .= '<span>' . htmlspecialchars($errors[$name]) . '</span>';
            $html .= '</div>';
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
            $required = !empty($field['is_required']);

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
