<div class="{{ $divClass }}">
    @if ($label)
        <label for="{{ $name }}" class="{{$labelClass}}">
            {{ $label }}
        </label>
    @endif
    <input
        class=" {{ $class }} border border-dark {{ $errors->has($name) ? ' is-invalid' : '' }}"
        type="{{ $type }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        {{ $attributes }}
        >
    @if ($errors->has($name))
        <p class="invalid-feedback">
            {{ $errors->first($name) }}
        </p>
    @endif
</div>