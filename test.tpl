<table>
	<tr><td>{=title|str.ucfirst}</td></tr>
	<tr>
		{for rows.0 as key,cell}
		<th>{=key}</th>
		{endfor rows.0}
	</tr>
	{for rows as row}
	<tr>
		{for row as cell}
		<td>{=cell} x {=forza.braccia}</td>
		{endfor row}
	</tr>
	{endfor}
	<tr>
		<td></td>
	</tr>
</table>


Rows.0 has {=rows.0|helpers.count} rows
<table>
	{for rows.0|helpers.group_by_3 as row}
	<tr>
	Row has {=row|helpers.count} rows
		{for row as cell}
		<td>Value: {=cell.value} Index: {=cell.index} Key: {=cell.key}</td>
		{endfor row}
	</tr>
	{endfor}
</table>

{if hasPrevious|helpers.castBoolean}
	hasPrevious
{else}
	noPrevious
{endif}

{if hasNext|helpers.castBoolean}
	{=nextLink|helpers.uppercase}
{else}
	noNext
{endif}
