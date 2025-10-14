<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        // เปิดให้สาธารณะเรียกดูได้
        return true;
    }

    /**
     * ทำความสะอาด/ปรับรูปอินพุตก่อน validate
     */
    protected function prepareForValidation(): void
    {
        $input = $this->all();

        // trim string ทั่วไป
        foreach (['q', 'cpu_brand', 'sort'] as $key) {
            if (isset($input[$key]) && is_string($input[$key])) {
                $input[$key] = trim($input[$key]);
            }
        }

        // เอาช่องว่างใน sort ออก: "price, -created_at" -> "price,-created_at"
        if (!empty($input['sort'])) {
            $input['sort'] = preg_replace('/\s+/', '', $input['sort']);
        }

        // บังคับ cpu_brand ให้อยู่ในรูปแบบตัวพิมพ์ตรงตาม whitelist (Intel/AMD)
        if (!empty($input['cpu_brand'])) {
            $cpu = strtolower($input['cpu_brand']);
            $input['cpu_brand'] = $cpu === 'intel' ? 'Intel' : ($cpu === 'amd' ? 'AMD' : $input['cpu_brand']);
        }

        // แคสต์ตัวเลข (ถ้ามาเป็น string)
        foreach (['brand_id','category_id','per_page','page'] as $intKey) {
            if (isset($input[$intKey])) $input[$intKey] = (int) $input[$intKey];
        }
        foreach (['price_min','price_max'] as $numKey) {
            if (isset($input[$numKey])) $input[$numKey] = is_numeric($input[$numKey]) ? (float) $input[$numKey] : $input[$numKey];
        }

        $this->replace($input);
    }

    public function rules(): array
    {
        return [
            'brand_id'     => ['sometimes','integer','min:1'],
            'category_id'  => ['sometimes','integer','min:1'],
            'cpu_brand'    => ['sometimes','string','in:Intel,AMD'],
            'price_min'    => ['sometimes','numeric','min:0'],
            'price_max'    => ['sometimes','numeric','gte:price_min'],
            'q'            => ['sometimes','string','max:100'],

            // รูปแบบ: sort=price,-created_at (comma-separated, มี "-" นำหน้าคือ DESC)
            'sort'         => [
                'sometimes','string','max:100',
                function (string $attribute, $value, \Closure $fail) {
                    $allowed = ['price','created_at','updated_at','ram_gb','storage_gb'];
                    foreach (explode(',', (string)$value) as $part) {
                        if ($part === '') continue;
                        $col = ltrim($part, '-');
                        if (!in_array($col, $allowed, true)) {
                            $fail(__('validation.custom.sort.invalid', [
                                'value'   => $part,
                                'allowed' => implode(',', $allowed),
                            ]));
                            return;
                        }
                    }
                },
            ],

            'per_page'     => ['sometimes','integer','min:1','max:100'],
            'page'         => ['sometimes','integer','min:1'],
        ];
    }

    /**
     * ข้อความ error (รองรับ i18n ผ่านไฟล์ lang)
     */
    public function messages(): array
    {
        return [
            'brand_id.integer'   => __('validation.custom.brand_id.integer'),
            'category_id.integer'=> __('validation.custom.category_id.integer'),
            'cpu_brand.in'       => __('validation.custom.cpu_brand.in'),
            'price_min.numeric'  => __('validation.custom.price_min.numeric'),
            'price_min.min'      => __('validation.custom.price_min.min'),
            'price_max.numeric'  => __('validation.custom.price_max.numeric'),
            'price_max.gte'      => __('validation.custom.price_max.gte'),
            'q.max'              => __('validation.custom.q.max'),
            'per_page.max'       => __('validation.custom.per_page.max'),
        ];
    }

    /**
     * ชื่อฟิลด์สำหรับข้อความ error ให้เป็นมิตร
     */
    public function attributes(): array
    {
        return [
            'brand_id'    => __('attributes.brand_id'),
            'category_id' => __('attributes.category_id'),
            'cpu_brand'   => __('attributes.cpu_brand'),
            'price_min'   => __('attributes.price_min'),
            'price_max'   => __('attributes.price_max'),
            'q'           => __('attributes.q'),
            'sort'        => __('attributes.sort'),
            'per_page'    => __('attributes.per_page'),
            'page'        => __('attributes.page'),
        ];
    }
}
