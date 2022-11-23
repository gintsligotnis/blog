<div class="form-check">
    <input
       id="{{ $id }}"
       type="checkbox"
       value="{{ $value }}"
       name="{{ $name }}"
       @if($checked)
           checked="checked"
       @endif
    />
    <label for="{{ $id }}">{{ $label }}</label>
</div>
