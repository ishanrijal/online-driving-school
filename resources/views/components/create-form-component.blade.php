<div class="form-container save-form">
    <div class="header">
        <h1>{{ $actionName }} {{ $entity }}</h1>
    </div>
    <form action="{{ $action }}" method="POST" enctype="multipart/form-data" id="entity-form">
        @csrf
        @if( $actionName=="Edit" )
            @method('PUT')
        @endif
        @foreach ($fields as $field)
            <div class="form-group">
                <div class="label-container">
                    <label for="{{ $field['id'] }}">{{ $field['label'] }}</label>
                </div>
                <div class="form-input">
                    @if ($field['type'] === 'select')
                        <select id="{{ $field['id'] }}" name="{{ $field['name'] }}" {{ $field['required'] ? 'required' : '' }} {{ $field['disabled'] ? 'disabled' : '' }}>
                            @foreach ($field['options'] as $value => $label)
                                <option value="{{ $value }}" 
                                    {{ (old($field['name']) == $value || $field['default'] == $value) ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    @elseif ( ($field['type'] === 'text' || $field['type'] === 'email' ) && $field['disabled'])
                        <input 
                            type="{{ $field['type'] }}" 
                            id="{{ $field['id'] }}" 
                            name="{{ $field['name'] }}" 
                            placeholder="{{ $field['placeholder'] }}" 
                            value="{{ $field['default'] }}" 
                            disabled
                        >
                    @else
                        <input 
                            type="{{ $field['type'] }}" 
                            id="{{ $field['id'] }}" 
                            name="{{ $field['name'] }}" 
                            placeholder="{{ $field['placeholder'] }}" 
                            value="{{ $field['default'] }}" 
                            {{ $field['required'] ? 'required' : '' }} 
                            {{ $field['disabled'] ? 'disabled' : '' }}
                        >
                    @endif
                    @error($field['name'])
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <x-input-error :messages="$errors->get($field['label'])" class="mt-2" />
        @endforeach
        @if( $imageUploader )
            <div class="form-group">
                <div class="label-container">
                    <label for="image">Upload Image<br>(350*250)</label>
                </div>
                <div class="form-input">
                    <input type="file" id="image" name="image">
                    <small>Recommended size: 350x250</small>
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        @endif
        @if( $resetButton )
            <div class="form-group">
                <div class="form-group">
                    <button type="button" class="save-btn btn" onclick="event.preventDefault(); document.getElementById('reset-form').submit();">
                        Reset Password
                    </button>
                </div>
            </div>
        @endif
        <button type="submit" class="save-btn">Save</button>
    </form>
</div>