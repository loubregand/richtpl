<!DOCTYPE html>
<html>
	<head>
		<title>{=title|str.upper}</title>
		<style>
			.title{
				text-align: center
			}
			td, th{
				border: 1px solid black
			}
		</style>
	</head>
	<body>
		<table>
			{# This is a comment #}
			<tr><td colspan="{=rows.0|array.count}" class="title">{=title|str.upper}</td></tr>
			{if rows}
				<tr>
					{set rows.0|array.keys as headers}
					{for headers as key}
						<th>{=key}</th>
					{endfor headers}
				</tr>
				{for rows as row}
				<tr>
					{for row as cell}
						<td>{=cell}</td>
					{endfor row}
				</tr>
				{endfor}
			{endif}
			{# start of a range comment}
			This will not be printed
			{here ends the range comment #}
			<tr>
				<td colspan="{=rows.0|array.count}">Showing {=rows|array.count} of {=number_of_books} books</td>
			</tr>
		</table>
	</body>
</html>
