<div class="{{ $divClass }}">
    @if ($label)
        <label for="{{ $name }}" class="{{$labelClass}}">
            {{ $label }}
        </label>
    @endif
    <textarea
        class=" {{ $class }} border border-dark {{ $errors->has($name) ? ' is-invalid' : '' }}"
        name="{{ $name }}"
        rows="{{$rows}}"
        {{ $attributes }}
        >{{ old($name, $value) }}</textarea>
    @if ($errors->has($name))
        <p class="invalid-feedback">
            {{ $errors->first($name) }}
        </p>
    @endif
</div>