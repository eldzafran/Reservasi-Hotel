@if ($room->status === 'maintenance')
    <div class="p-3 mb-3 bg-yellow-100 border border-yellow-300 rounded">
        Kamar ini sedang <strong>maintenance</strong> dan tidak dapat dipesan saat ini.
    </div>
@endif
