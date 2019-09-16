<select class="so-drd" name="{{ $name }}">
    <option value=""></option>
    @foreach($operators as $item)
        <option value="{{ $item['key'] }}">{{ $item['name'] }}</option>
    @endforeach
</select>