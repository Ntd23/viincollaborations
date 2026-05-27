{{-- English description: Renders package purchase settings save action. --}}

<x-core-setting::section.action>
    <div class="d-flex flex-wrap align-items-center justify-content-end gap-3">
        <x-core::button
            type="submit"
            color="primary"
            icon="ti ti-device-floppy"
            :form="$form ?? null"
        >
            {{ trans('core/setting::setting.save_settings') }}
        </x-core::button>
    </div>
</x-core-setting::section.action>
