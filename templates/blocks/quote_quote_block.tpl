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
    <{foreach item=quote from=$block}>
        <tr class = "<{cycle values = 'even,odd'}>">
            <td>
            <{$quote.id}>
            <{$quote.cid}>
            <{$quote.author_id}>
            <{$quote.quote}>
            <{$quote.online}>
            <{$quote.created}>
            <{$quote.updated}>
            </td>
        </tr>
    <{/foreach}>
</table>