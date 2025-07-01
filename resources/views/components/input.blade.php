<div class="mb-08rem w-full transition relative">
    <label for="{{ $id }}" class="mb-2px block transition">{{ $label }}</label>
    <input class="form-login-input text-white transition {{ $classes }}" @if ($type==='number' ) type="text"
        oninput="allowIntegerOnly(this)" @else type="{{ $type }}" @endif name="{{ $name }}" id="{{ $id }}"
        placeholder="{{ $placeholder }}" value="{{ $value }}" {{ $attributes }} />
    <span class="text-primary {{ $name }}" id="error_{{ $name }}"></span>
</div>
