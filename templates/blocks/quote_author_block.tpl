<table class="outer">
    <tr class="head">
        <th><{$smarty.const.MB_QUOTE_ID}></th>
        <th><{$smarty.const.MB_QUOTE_NAME}></th>
        <th><{$smarty.const.MB_QUOTE_COUNTRY}></th>
        <th><{$smarty.const.MB_QUOTE_BIO}></th>
        <th><{$smarty.const.MB_QUOTE_PHOTO}></th>
        <th><{$smarty.const.MB_QUOTE_CREATED}></th>
        <th><{$smarty.const.MB_QUOTE_UPDATED}></th>
    </tr>
    <{foreach item=author from=$block}>
        <tr class = "<{cycle values = 'even,odd'}>">
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