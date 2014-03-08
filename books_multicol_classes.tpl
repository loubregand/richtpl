<!DOCTYPE html>
<html>
	<head>
		<title>{=title|str.upper}</title>
		<style>
			.title{
				text-align: center;
			}
			td, th{
				border: 1px solid black;
			}
			.first th,.last th{
				color: green;
			}
		</style>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="test.js"></script>
	</head>
	<body>
		<table class="maintable">
			<tr>
				<td>
					<table>
						{set colors|array.iterate as colors}
						{for rows|array.iterate as ar}
							<tr style="background-color: {=colors.cycle.value}">
								{for array.range.3|array.iterate as columns}
									<td class="book {if columns.fwd.isFirst}first{elseif columns.isLast}last{endif}{if ar.fwd.value}{else} empty{endif}">
										{if ar.value as cell}
											{=tablePartial}
										{elseif noMoreBooks as text}
											{=text}
										{else}
											<div style="text-align: center">{=noMoreBooksText}</div>
										{endif}
									</td>
								{endfor}
							</tr>
						{else}
							NO BOOKS AT ALL!
						{endfor}
					</table>
				</td>
			</tr>
			<tr>
				<td>Showing {=rows|array.count} of {=number_of_books} books</td>
			</tr>
		</table>
	</body>
</html>
