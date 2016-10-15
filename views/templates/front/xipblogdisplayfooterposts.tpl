{if isset($xipblogposts)}
<div class="footer_blog_area col-sm-12 clearfix">
	{if isset($xipbdp_title)}
		<div class="footer_blog_title">
			<em>{$xipbdp_title}</em>
		</div>
	{/if}
	<div class="footer_blog_post carousel">
		{foreach from=$xipblogposts item=xipblgpst}
		<div class="blog_post">
			<div class="blog_post_left">
				<p>
					{$xipblgpst.post_date|date_format:"<span>%e</span> <span>%b</span>"}
				</p>
			</div>
			<div class="blog_post_right">
				<h3 class="post_title">
					<a href="{$xipblgpst.link}">{$xipblgpst.post_title}</a>
				</h3>
				<div class="post_description">
					<p>
						{if isset($xipblgpst.post_excerpt) && !empty($xipblgpst.post_excerpt)}
							{$xipblgpst.post_excerpt|truncate:120:'...'|escape:'html':'UTF-8'}
							<a class="read_more" href="{$xipblgpst.link}"> {l s='Read More >>' mod='xipblogdisplayposts'}</a>
						{else}
							{$xipblgpst.post_content|truncate:120:'...'|escape:'html':'UTF-8'}
							<a class="read_more" href="{$xipblgpst.link}"> {l s='Read More >>' mod='xipblogdisplayposts'}</a>
						{/if}
					</p>
				</div>
			</div>
		</div>
		{/foreach}
	</div>
</div>
{/if}