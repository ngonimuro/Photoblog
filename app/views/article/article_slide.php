        <section id="main">
            <h2><?php echo $article->title; ?></h2>
            <!-- include Google reCAPTCHA -->
            <script src='https://www.google.com/recaptcha/api.js'></script>
            <article><?php echo $article->text; ?></article>
            <?php if($imgCount > 0): ?>
                <div id ="images_mini">
                    <?php for($i = 1; $i <= $imgCount; $i++): ?>
                        <?php if($i > 9): ?>
                            <a class="fancybox" rel="group" href="<?php echo article_pics_url() . $article->path . '/bild_' . $i . '_l.jpg'; ?>"><img src="<?php echo article_pics_url() . $article->path . '/bild_' . $i . '_s.jpg'; ?>" alt="" /></a>
                        <?php else: ?>
                            <a class="fancybox" rel="group" href="<?php echo article_pics_url() . $article->path . '/bild_0' . $i . '_l.jpg'; ?>"><img src="<?php echo article_pics_url() . $article->path . '/bild_0' . $i . '_s.jpg'; ?>" alt="" /></a>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
            <p><?php if($article->tags != 1 AND $cat != NULL): ?>Kategorie: <?php echo anchor(base_url('category/show/' . $article->tags), $cat); ?><?php endif; ?></p>
            <div id="fb-root"></div>
            <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/de_DE/sdk.js#xfbml=1&version=v2.8";
                fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
            </script>
            <div class="twitter-container"><a href="https://twitter.com/share" class="twitter-share-button" data-size="large" data-text="<?php echo $article->title; ?>" data-lang="en" data-show-count="false">Tweet</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script></div><div class="fb-share-button" data-href="<?php echo base_url('article/show/' . $article->path); ?>" data-layout="button" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">Teilen</a></div>
            <?php if(in_array($article->author, $this->config->item('main_authors'))): ?>
            <p><span class="left">Erstellt von <?php echo $article->author; ?></span><span class="right"><?php echo date('d.m.Y', strtotime($article->date)); ?></span></p>
            <?php else: ?>
            <p><span class="left">Gastbeitrag von <?php echo $article->author; ?></span><span class="right"><?php echo date('d.m.Y', strtotime($article->date)); ?></span></p>            
            <?php endif; ?>
            <?php if($article->tags != 1): ?>
                <?php if($comments != null): ?>    
                    <div id="comments">
                        <h3><?php echo count($comments); ?> Kommentar(e)</h3>
                        <?php foreach($comments as $comment): ?>
                            <div class="comment">
                                <p><?php echo $comment->name; ?> schrieb am <?php echo date('d.m.Y H:i', strtotime($comment->date)); ?></p>
                                <div><?php echo nl2br($comment->text); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <?php if(isset($validation_errors) or isset($msg)): ?>
                    <div class="requirements">
                        <?php if(isset($validation_errors)): ?>
                            <?php echo $validation_errors; ?>
                        <?php else: ?>
                            <?php echo $msg; ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php 
                echo form_open(base_url('article/show/' . $article->path), ['id' => 'comment-form']);
                echo '<h3>Artikel kommentieren</h3>';
                echo form_input([
                    'name' => 'name',
                    'placeholder' => 'Name *'
                ]);
                echo form_input([
                    'name' => 'email',
                    'placeholder' => 'Email (optional)',
                    'type' => 'email'
                ]);            
                echo form_textarea([
                    'name' => 'text',
                    'placeholder' => 'Kommentar verfassen ... *'
                ]);
                echo '<div class="g-recaptcha" data-sitekey="6LeZwBEUAAAAABUYwQK8T_jkN6s5M-c8Cp6ovdN_"></div>';
                echo form_submit([
                    'name' => 'comment_submit',
                    'value' => 'Kommentieren'
                ]);
                echo form_reset([
                    'name' => 'comment_reset',
                    'value' => 'Zurücksetzen'
                ]);
                echo form_close();
                ?>
            <?php endif; ?>
        </section>
