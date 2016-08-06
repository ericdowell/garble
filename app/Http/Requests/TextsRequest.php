<?php

namespace Garble\Http\Requests;

use Garble\Text;
use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class TextsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $userId = auth()->user()->id;
        //Will fail rules
        if (empty($this->input('slug'))) {
            return true;
        }
        try {
            $text = Text::findByCurrentSlug();
            //It's a create and rules will fail.
            if ($this->isMethod('POST')) {
                return true;
            }

            //Otherwise it's an update PUT
            return $text->user->id == $userId;
        } catch (ModelNotFoundException  $error) {
            //Field doesn't match current user, denied
            if ($this->input('user_id') != $userId) {
                return false;
            }
            //Most likely a create/store action
            if ($this->input('text_type')) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array
     */
    final public function rules()
    {
        $rules = Text::rules();
        $model = $this->getModel();
        if ($model instanceof Text && $this->input('text_id') == $model->text_id) {
            $rules['slug'] = sprintf('%s,"%s"', $rules['slug'], $model->id);
        }

        if (! property_exists($this, 'rules') || ! is_array($this->rules)) {
            return $rules;
        }

        return array_merge($rules, $this->rules);
    }

    /**
     * @return array
     */
    final public function messages()
    {
        $messages = [
            'slug.unique' => 'The :attribute provided is already in use.',
            'required' => 'The :attribute is required',
        ];

        if (! property_exists($this, 'messages') || ! is_array($this->messages)) {
            return $messages;
        }

        return array_merge($messages, $this->messages);
    }

    /**
     * @return void|Text
     */
    protected function getModel()
    {
        try {
            return Text::findByCurrentSlug();
        } catch (ModelNotFoundException $error) {
        }
    }
}
