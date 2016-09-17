<div class="grid-container">
	<div class="grid-100">
		<!-- Intro -->
		<div class="smooth-box">
			@include('widgets.messages')
			
			<section id="site-intro">
				<h2>Introduction to Infinity</h2>
				<p>
					<em>Infinity</em>, or <em>Infinity Next</em>, is an open-source imageboard software suite built on the <a href="//laravel.com">Laravel</a> framework in PHP.
					It is being built with the intention of superceding all currently available imageboard applications,
					inspired by my own long time use of imageboards and general low expectations for existing options.
					My two large contributions with the original <a href="https://github.com/ctrlcctrlv/infinity">Infinity Development Group</a> gave rise to the concept of starting from scratch.
				</p>
				<p>
					The ultimate problem with these older codebases is their lack of direction.
					New, shiny features have to be built around existing flaws.
					When an inflatable springs a leak and you only apply a patch, the sides of the patch will also start to leak.
					Without adequaely addressing the problem, you eventually end up with a large mass that doesn't actually improve the feature.
					This is where we are at now.
				</p>
				<p>
					I am someone with 4 years of professional experience in web development, and twice as many years in hobby work.
					Having been in teams and seen the long-term problems of code complications first hand,
					I know a complete rewrite with a proper foundation is the only real solution to the problem.
					The limited numbers of individuals working on separate code bases do not have the resources to slowly reform thousands of lines of code.
					Without a framework, the state of affairs will continue to deterroriate as more is done by more developers.
				</p>
				<p>
					With Infinity, we can aspire to add new features much quicker.
					Complex user permission masks, a wider variety of 3rd party embeds in posts, streamlined attachment management (such as hash banning).
					Even features that are currently impossible to do, like password protected boards, are a cinch when old caching methods are discarded in favor of better technologies.
					These things are all very doable in a new architecture, which is what I aim to build.
				</p>
				<p>
					<strong><a href="{{{url('contribute')}}}">Help me build Infinity, and help the imageboard communities go beyond.</a></strong>
				</p>
			</section>
		</div>
		
		<!-- Blurb -->
		<div class="smooth-box">
			<section id="site-blurb">
				<div class="grid-50">
					<h3>To the Developers,</h3>
					<h4>Existing software caches in HTML</h4>
					<p>
						When you access <tt>/b/</tt>, there is a file called <tt>/b/index.html</tt> on the server.
						This HTML file is updated every time a post is made.
						Every page on a board has a subsequent <tt>2.html</tt> file.
						The reason an imageboard commonly has an arbitary 15 page limit is due to the time it takes to recache every page after a new thread is created.
						Some developers think they're clever by writing caches to the harddisk, but the bottleneck becomes the very expensive and hard limited disk I/O.
						With Infinity, posts never need to be deleted.
						Caching will work with existing technologies like Memcached.
					</p>
					<p>
						Aside from being ineffecient, it also causes <em>problems</em>.
						If you wanted to make a password-protected board, you'd not be able to, because, once unlocked, the page would be recached without a password form.
						Features (like the already extant delete-your-own-post button on Infinity) are impossible because the site cannot modify the view based on the request.
						Everything becomes more complicated with system built like this.
					</p>
					<p>
						There have been attempts at repairing this by implementing a front-end controller, but these patches caused problems on live servers.
						With enough time and effort, I'm sure it is possible to work around this system or rebuild it, but that's like rebuilding the engine block of a beat up Honda Civic. Why bother?
					</p>
					
					
					<h4>Existing software has a MySQL table for every board</h4>
					<p>
						<em>Every. Board.</em>
					</p>
					<p>
						<tt>posts_a</tt>, <tt>posts_b</tt>, and so on.
						MySQL queries on sites with a variable number of boards, such as in the Infinity branch, can take a full minute or more to join all 8000+ tables.
						Ineffecient queries take even longer, as they will have to reconnect and query each table individually.
						Since there is no model system on existing imageboards, SQL is written by hand, and less experienced programmers will make this mistake.
					</p>
					<p>
						There have been attempts at replacing this system with a global <tt>posts</tt> table, but that involves redoing <em>every single query on the system</em>.
						Since there aren't even any classes in most imageboard suites, this is a massive undertaking that would affect every file in the codebase.
						Again, with enough time and effort, anything is possible on, but why bother?
					</p>
					
					
					<h4>Existing software has no MVC</h4>
					<p>
						There is no front-end controller.<br />
						As previously mentioned, files are distributed from physical points on the harddrive after being generated by specific events.<br />
						Routing and dealing with requests is a cinch in Laravel. See how controllers work on <a href="https://github.com/nextchan/infinity-next/blob/master/app/Http/routes.php">this very website</a>.
					</p>
					<p>
						There is no ODB, or even classes.<br />
						All SQL is done by hand, with varying results in effeciency based on who wrote it.
						This compounds with the general state of disrepair the database is in.<br />
						Laravel has one of the best framework models I've ever seen and I encourage everyone to <a href="http://laravel.com/docs/5.0/eloquent">check it out</a>.
					</p>
					<p>
						There is Twig.<br />
						<em>Twig</em> is a popular templating system, and while it is much more serviceable as a library than the codebase it resides in is, its biggest fault is translations.
						Localization on Infinity Branch is very clunky and <em>changing any letter in the master language will break all translations of it.</em>
						The system is literally <tt>[ "sp" => [ 'English translation' => 'Traducción al español' ] ]</tt>.<br />
						Laravel has a <a href="http://laravel.com/docs/5.0/localization">built-in translation system</a> that is much more robust and easier for translators to work with.
					</p>
					
					
					<h4>Existing software has poor HTML, CSS &amp; JS conventions</h4>
					<p>
						While working on Infinity, I decided I would try to resolve a few quality of life complaints users were having in /operate/.
						One of the &quot;easy&quot; requests I saw was to add a &quot;Post a reply&quot; link at the bottom of the page that would open the reply box.
					</p>
					<p>
						This simple fix turned into a two-day affair.
						I used JS to insert the link (as opening the reply box required JS).
						To do this, I needed another element to insert the link after in the footer.
						I didn't find anything suitable, so did a little work to give new class names to elements.
						<em>Big mistake.</em>
					</p>
					<p>
						This simple change broke all thread scripts because they relied on the arbitrary jQuery selector: <tt>$('form[name="postcontrols"] > .delete:first')</tt>.
						This had been copy+pasted into every single utility script we had for thread and post views.
					</p>
					<p>
						The unfortunate reality is that everything is like this, needlessly.
						It's so easy to write good HTML, CSS, and jQuery and for some reason it just was not done.
					</p>
					
					<p>
						If you agree that the imageboard communities deserve better software, check out the <a href="{{{url('contribute')}}}">contribution page</a> for ways to help out.
					</p>
				</div>
				
				<div class="grid-50">
					<h3>To the Imageboard User,</h3>
					<h4>"Why fix what isn't broken?"</h4>
					<p>
						If you are someone who is resistant to change, there's not much I can write here to convince you.
						Your mind is already made up. You like things as they are, no matter their shortcomings, and you don't want anything else.
						You are entitled to that opinion, and if this is successful and ends up on a website you visit, I hope you like it as much as you do what you currently use.
					</p>
					<p>
						<em>However</em>, for everyone else: it <em>is</em> broken.
						It's easy to overlook inconveniences if you're used to them.
						There are simple additions or changes that everyone using an imageboard could appreciate, but are difficult to add (or even outright impossible) due to the aging architecture they run on.
						Even if they are at all doable, simply because of how things are built, the time it takes to get <em>any</em> feature out is tremendously bloated.
					</p>
					<p>
						If you want, go <a href="{{url("/cp/boards/create")}}">create your own board</a> right now.
						You'll notice that, while browsing your board, you will have an actions menu using the same URL as a normal anonymous user.
						This is something that <em>already exists</em> on this software that is completely impossible on existing imageboards due to flaws in the technology.
						There is no way to render a page differently depending on who accesses it, but on Infinity Next, it is.
						This is why you have to use <tt>/mod.php?</tt> on 8chan.
					</p>
					<p>
						Password protected boards, boards restricted to board owners / site staff, variable user permissions, a built-in thread archival, a robust API (for 3rd party tools), board settings for things like number of threads per page, and so on.
						The list of what existing imageboards <em>cannot do</em> that Infinity and Laravel are readily capable of is gigantic.
						Even if you don't like specifc ideas, the fact is that they are <em>possible</em>.
					</p>
					<p>
						If these things interest you, check out our <a href="{{{url('contribute')}}}">contribution page</a> for more details and ways to help out.
					</p>
				</div>
			</section>
		</div>
		
		<!-- FAQ -->
		<div class="smooth-box">
			<section id="site-faq">
				<h2>Frequently Asked Questions</h2>
				
				<h3>Why should I donate?</h3>
				<p>
					If you are even a casual imageboard user, you've probably had a moment where you wanted something to work differently or better.
					A lot of "easy" additions, like password-protected boards, are not possible because of <em>massive, all-encompassing, fundamental flaws</em> in the software.
					I do not want to see imageboards go the way of BBS and Usenet, and neither should you.
					Without a reliable codebase and a developer who can afford to maintain and direct it, these problems will not go away and, at best, will stay the same.
				</p>
				
				<h3>Will this website compete with 4chan and 8chan?</h3>
				<p>
					<em>No.</em> I am building software, not a community.
					Content added to this site may vanish at any time, as it is for development and testing.
				</p>
				
				<h3>How can I contribute?</h3>
				<p>
					Infinity will be open-source once we enter version 0.1, which will happen immediately after I've written documentation for what I've already built.
					I cannot offer pay for work, as I'm already strapped for cash, but I will gladly serve as a reference to any serious contributors.
					If you are interested, I would seriously advise looking into the Laravel framework and familiarizing yourself with its architecture. There is a slight learning curve.
				</p>
				<p>
					Our git repository is accessible <a href="https://github.com/nextchan/infinity-next/">here</a>.
				</p>
				
				<h3>Why did you build your own donation system? Why build it first thing?</h3>
				<p>
					Infinity's donation form was developed with Laravel's Stripe integration <em>specifically</em> to avoid Patreon, GoFundMe, Grattipay, and Kickstarter.
				</p>
				<p>
					Users of particular imageboards may be aware that those services are unfaithful to their patrons, despite taking a gratuitous 5 to 10% out of donations.
					They will kick anyone off their programs for any reason, or no reason at all.
					In the interest of webmasters, I've built a custom cashier system that can later be converted into a donation form for any website running Infinity.
					That way, only Stripe can cut funding to the website, and reliance on meddling, self-serving middleman can be avoided entirely.
				</p>
				
				<h3>I do not like this theme / it's too far from what I'm used to.</h3>
				<p>
					The website is being built with themeability in mind. The comforting blue gradient will return for those who want it.
				</p>
				
				<h3>Why PHP!?</h3>
				<p>
					<strong>PHP is the easiest language to get hosting for.</strong> No matter how junk your shared host is, they will have PHP.
					Since Wordpress is the most popular software suite on the Internet these days, it's impossible to find a host that doesn't accept PHP.
				</p>
				<p>
					<strong>PHP is a very forgiving syntax.</strong> It shouldn't be hard to get Infinity hosted and configured to your liking.
					PHP is a very easy, rookie-friendly language that even a novice host can make changes to.
				</p>
				<p>
					<strong>You know PHP.</strong> Every webmaster on the Internet has at least dabbled in PHP.
					With a gargantuan developer pool, finding help and contributions for Infinity will be easier on PHP.
				</p>
				<p>
					<strong>It's what I'm best at!</strong> Almost all of my experience as a developer comes from working with PHP.
					I understand its flaws (trust me, I do!), but it's what I know.
					For a project like this, where my objective is to have things done correctly and quickly, PHP is the best choice.<br />
					One day I'll learn Python, but for now, it's PHP or bust.
				</p>
			</section>
		</div>
	</div>
</div>
