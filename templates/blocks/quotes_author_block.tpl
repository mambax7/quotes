<table class="outer">
    <tr class="head">
        <th><{$smarty.const.MB_QUOTES_ID}></th>
        <th><{$smarty.const.MB_QUOTES_NAME}></th>
        <th><{$smarty.const.MB_QUOTES_COUNTRY}></th>
        <th><{$smarty.const.MB_QUOTES_BIO}></th>
        <th><{$smarty.const.MB_QUOTES_PHOTO}></th>
        <th><{$smarty.const.MB_QUOTES_CREATED}></th>
        <th><{$smarty.const.MB_QUOTES_UPDATED}></th>
    </tr>
    <{foreach item=author from=$block}>
        <tr class="<{cycle values = 'even,odd'}>">
            <td>
                <{$author.id}>
                <{$author.name}>
                <{$author.country}>
                <{$author.bio}>
                <{$author.photo}>
                <{$author.created}>
                <{$author.updated}>
            </td>
        </tr>
    <{/foreach}>
</table>
