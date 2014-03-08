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
			<tr>
				<td>
					<table>
						{set colors|array.iterate as colors}
						{for rows|array.iterate as ar}
							<tr style="background-color: {=colors.cycle.value}">
								{for 2}
									<td class="book">
										{if ar.fwd.value as cell}
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
