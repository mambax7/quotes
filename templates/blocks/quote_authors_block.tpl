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
    <{foreach item=authors from=$block}>
        <tr class = "<{cycle values = 'even,odd'}>">
            <td>
            <{$authors.id}>
            <{$authors.name}>
            <{$authors.country}>
            <{$authors.bio}>
            <{$authors.photo}>
            <{$authors.created}>
            <{$authors.updated}>
            </td>
        </tr>
    <{/foreach}>
</table>