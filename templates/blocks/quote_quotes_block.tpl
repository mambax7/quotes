<table class="outer">
    <tr class="head">
        <th><{$smarty.const.MB_QUOTE_ID}></th>
        <th><{$smarty.const.MB_QUOTE_CID}></th>
        <th><{$smarty.const.MB_QUOTE_AUTHOR_ID}></th>
        <th><{$smarty.const.MB_QUOTE_QUOTE}></th>
        <th><{$smarty.const.MB_QUOTE_ONLINE}></th>
        <th><{$smarty.const.MB_QUOTE_CREATED}></th>
        <th><{$smarty.const.MB_QUOTE_UPDATED}></th>
    </tr>
    <{foreach item=quotes from=$block}>
        <tr class = "<{cycle values = 'even,odd'}>">
            <td>
            <{$quotes.id}>
            <{$quotes.cid}>
            <{$quotes.author_id}>
            <{$quotes.quote}>
            <{$quotes.online}>
            <{$quotes.created}>
            <{$quotes.updated}>
            </td>
        </tr>
    <{/foreach}>
</table>