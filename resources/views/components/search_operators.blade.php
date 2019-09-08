<select class="s-drd">
    <option value=""></option>
    @foreach($operators as $item)
        <option value="{{ $item['key'] }}">{{ $item['name'] }}</option>
    @endforeach
</select>