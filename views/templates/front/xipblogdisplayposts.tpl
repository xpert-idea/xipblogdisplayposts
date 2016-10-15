<div class="home_blog_post_area">
	<div class="home_blog_post">
		{if isset($xipbdp_title)}
			<h3 class="page-heading">
				<em><a href="{$xipblogmainlink}">{$xipbdp_title}</a></em>
			</h3>
		{/if}
		{if isset($xipbdp_subtext)}
			<p class="page_subtitle">
				{$xipbdp_subtext}
			</p>
		{/if}
		<div class="row home_blog_post_inner carousel">
		{foreach from=$xipblogposts item=xipblgpst}
			<article id="blog_post" class="blog_post col-xs-12 col-sm-4">
				<div class="blog_post_content">
					<div class="blog_post_content_top">
						<div class="post_thumbnail">
							{if $xipblgpst.post_format == 'video'}
								{assign var="postvideos" value=','|explode:$xipblgpst.video}
								{include file="./post-video.tpl" videos=$postvideos width='512' height="265" class="{if $postvideos|@count > 1 }carousel{/if}"}
							{elseif $xipblgpst.post_format == 'audio'}
								{assign var="postaudio" value=','|explode:$xipblgpst.audio}
								{include file="./post-audio.tpl" audios=$postaudio width='512' height="265" class="{if $postaudio|@count > 1 }carousel{/if}"}
							{elseif $xipblgpst.post_format == 'gallery'}
								{include file="./post-gallery.tpl" gallery=$xipblgpst.gallery_lists imagesize="home_default" class="{if $xipblgpst.gallery_lists|@count > 1 }carousel{/if}"}
							{else}
								<img class="img-responsive" src="{$xipblgpst.post_img_home_default}" alt="{$xipblgpst.post_title}">
								<div class="blog_mask">
									<div class="blog_mask_content">
										<a class="thumbnail_lightbox" href="{$xipblgpst.post_img_large}">
											<i class="icon_plus"></i>
										</a>
									</div>
								</div>
							{/if}
						</div>
					</div>
					<div class="post_content">
						<h3 class="post_title"><a href="{$xipblgpst.link}">{$xipblgpst.post_title}</a></h3>
						<div class="post_meta clearfix">
							<p class="meta_author">
								{l s='Posted by ' mod='xipblogdisplayposts'}
								<span>{$xipblgpst.post_author_arr.firstname} {$xipblgpst.post_author_arr.lastname}</span>
							</p>
							<p class="meta_date">
								{$xipblgpst.post_date|date_format:"%b %dTH, %Y"}
							</p>
							<p class="meta_category">
									<a href="{$xipblgpst.category_default_arr.link}">{$xipblgpst.category_default_arr.name}</a>
							</p>
						</div>
						<div class="post_description">
							{if isset($xipblgpst.post_excerpt) && !empty($xipblgpst.post_excerpt)}
								<p>{$xipblgpst.post_excerpt|truncate:100:'...'|escape:'html':'UTF-8'}</p>
							{else}
								<p>{$xipblgpst.post_content|truncate:100:'...'|escape:'html':'UTF-8'}</p>
							{/if}
						</div>
						<div class="read_more">
							<a class="more" href="{$xipblgpst.link}">{l s='Continue' mod='xipblogdisplayposts'} <i class="arrow_right"></i></a>
						</div>
					</div>
				</div>
			</article>
		{/foreach}
		</div>
	</div>
</div>