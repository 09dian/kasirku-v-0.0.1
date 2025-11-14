<x-filament-panels::page>
    <form wire:submit.prevent="save" class="space-y-6">
        {{-- Form input printer --}}
        <div>
            {{ $this->form }}
        </div>

        {{-- Tombol Simpan --}}
        <div class="pt-6 border-t border-gray-200">
            <x-filament::button type="submit" color="primary" class="mt-4">
                Simpan Pengaturan
            </x-filament::button>
        </div>
    </form>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('reloadPage', () => {
                setTimeout(() => {
                    location.reload();
                }, 150);
            });
        });
    </script>

</x-filament-panels::page>
