

{if isset($xipbdp_title)}{$xipbdp_title}{/if}
{if isset($xipbdp_subtext)}{$xipbdp_subtext}{/if}
{if isset($xipblogposts)}

{foreach from=$xipblogposts item=xipblgpst}
		{$xipblgpst.id_xipposts}<br>
	    <a href="{$xipblgpst.link}">link</a><br>
	    {$xipblgpst.post_author}<br>
	    {$xipblgpst.post_author_arr.firstname}<br>
	    {$xipblgpst.post_author_arr.lastname}<br>
	    {$xipblgpst.post_date}<br>
	    {$xipblgpst.comment_status}<br>
	    {$xipblgpst.post_password}<br>
	    {$xipblgpst.post_modified}<br>
	    {$xipblgpst.post_parent}<br>
	    {$xipblgpst.category_default}<br>
	    {$xipblgpst.category_default_arr.id}<br>
	    {$xipblgpst.category_default_arr.name}<br>
	    {$xipblgpst.category_default_arr.link_rewrite}<br>
	    {$xipblgpst.category_default_arr.title}<br>
	    {$xipblgpst.category_default_arr.link}<br>
	    {$xipblgpst.post_type}<br>
	    {$xipblgpst.post_format}<br>
	    {$xipblgpst.post_img}<br>
	    {$xipblgpst.post_img_small}<br>
	    {$xipblgpst.post_img_medium}<br>
	    {$xipblgpst.post_img_large}<br>
	    {$xipblgpst.video}<br>
	    {$xipblgpst.audio}<br>
	    {$xipblgpst.gallery} <br>
	    {$xipblgpst.related_products}<br>
	    {$xipblgpst.comment_count}<br>
	    {$xipblgpst.position}<br>
	    {$xipblgpst.active}<br>
	    {$xipblgpst.id_lang}<br>
	    {$xipblgpst.post_title}<br>
	    {$xipblgpst.meta_title}<br>
	    {$xipblgpst.meta_description}<br>
	    {$xipblgpst.meta_keyword}<br>
	    {$xipblgpst.post_content}<br>
	    {$xipblgpst.post_excerpt}<br>
	    {$xipblgpst.link_rewrite}<br>
	    {$xipblgpst.id_shop}<br>
{/foreach}

{/if}