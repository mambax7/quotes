<table class="outer">
    <tr class="head">
        <th><{$smarty.const.MB_QUOTES_ID}></th>
        <th><{$smarty.const.MB_QUOTES_PID}></th>
        <th><{$smarty.const.MB_QUOTES_TITLE}></th>
        <th><{$smarty.const.MB_QUOTES_DESCRIPTION}></th>
        <th><{$smarty.const.MB_QUOTES_IMAGE}></th>
        <th><{$smarty.const.MB_QUOTES_WEIGHT}></th>
        <th><{$smarty.const.MB_QUOTES_COLOR}></th>
        <th><{$smarty.const.MB_QUOTES_ONLINE}></th>
    </tr>
    <{foreach item=category from=$block}>
        <tr class="<{cycle values = 'even,odd'}>">
            <td>
                <{$category.id}>
                <{$category.pid}>
                <{$category.title}>
                <{$category.description}>
                <{$category.image}>
                <{$category.weight}>
                <{$category.color}>
                <{$category.online}>
            </td>
        </tr>
    <{/foreach}>
</table>
