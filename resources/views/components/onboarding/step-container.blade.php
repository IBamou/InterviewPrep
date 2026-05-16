<div x-show="step === {{ $step }}" x-transition:enter="step-enter" class="step-enter" {{ $attributes->merge(['style' => $step > 1 ? 'display: none;' : '']) }}>
    {{ $slot }}
</div>
