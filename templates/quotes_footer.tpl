    <{if $bookmarks|default:0 != 0}>
        <div class="quotes-system-block">
            <{include file="db:system_bookmarks.tpl"}>
        </div>
    <{/if}>

    <{if $fbcomments|default:0 != 0}>
        <div class="quotes-system-block">
            <{include file="db:system_fbcomments.tpl"}>
        </div>
    <{/if}>

    <{if $commentsnav|default:'' != '' || $lang_notice|default:'' != '' || $comment_mode|default:'' != ''}>
    <div class="quotes-system-block">
        <{if $commentsnav|default:'' != ''}>
            <div class="quotes-comments-nav"><{$commentsnav}></div>
        <{/if}>
        <{if $lang_notice|default:'' != ''}>
            <div class="quotes-notice"><{$lang_notice}></div>
        <{/if}>
        <{if $comment_mode|default:'' == "flat"}>
            <{include file="db:system_comments_flat.tpl"}>
        <{elseif $comment_mode|default:'' == "thread"}>
            <{include file="db:system_comments_thread.tpl"}>
        <{elseif $comment_mode|default:'' == "nest"}>
            <{include file="db:system_comments_nest.tpl"}>
        <{/if}>
    </div>
    <{/if}>

    <div class="quotes-footer">
        <span><{$copyright|default:''}></span>
        <{if $xoops_isadmin}>
            <a href="<{$admin|escape:'html'}>"><{$smarty.const.MD_QUOTES_ADMIN|default:'Admin'|escape}></a>
        <{/if}>
    </div>
    <{include file='db:system_notification_select.tpl'}>
</div>
