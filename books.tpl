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
			{# Questo è un commento #}
			<tr><td colspan="{=rows.0|array.count}" class="title">{=title|str.upper}</td></tr>
			{if rows}
				<tr>
					{for rows.0 as key,cell}
						<th>{=key}</th>
					{endfor rows.0}
				</tr>
				{for rows as row}
				<tr>
					{for row as cell}
						<td>{=cell}</td>
					{endfor row}
				</tr>
				{endfor}
			{endif}
			{# start comment}
			This will not be printed
			{end of comment #}
			<tr>
				<td colspan="{=rows.0|array.count}">Showing {=rows|array.count} of {=number_of_books} books</td>
			</tr>
		</table>
	</body>
</html>
