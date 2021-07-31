<table class="outer">
    <tr class="head">
        <th><{$smarty.const.MB_QUOTES_ID}></th>
        <th><{$smarty.const.MB_QUOTES_CID}></th>
        <th><{$smarty.const.MB_QUOTES_AUTHOR_ID}></th>
        <th><{$smarty.const.MB_QUOTES_QUOTE}></th>
        <th><{$smarty.const.MB_QUOTES_ONLINE}></th>
        <th><{$smarty.const.MB_QUOTES_CREATED}></th>
        <th><{$smarty.const.MB_QUOTES_UPDATED}></th>
    </tr>
    <{foreach item=quote from=$block}>
        <tr class="<{cycle values = 'even,odd'}>">
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
