<table>
	<thead>
		<tr>
			<th>CHECK LIST</th>
			<th>BUTIR PERTANYAAN</th>
			<th>KUALITATIF</th>
			<th>JUMLAH/TARGET</th>
			<th>KEBERADAAN</th>
			<th>KESESUAIAN STANDAR</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($questions as $question)
			<tr>
				<td>{{ $question->code }}</td>
        <td>{{ $question->text }}</td>
				<td>{{ $question->response->description }}</td>
				<td>{{ $question->response->amount_target }}</td>
				<td>{{ $question->response->existence }}</td>
				<td>{{ $question->response->compliance }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
