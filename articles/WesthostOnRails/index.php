<?php

# get common
require "{$_SERVER['DOCUMENT_ROOT']}/scripts/common.php";

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>Tutorial: Westhost on Rails</title>
<?php docHead(); ?>
</head>
<body>
<?php message(); ?>
<div id="content">
  <h1>Westhost on Rails</h1>
  <h3>By Aaron Gustafson</h3>
  
  <p id="disclaimer"><strong>The Requisite Disclaimer:</strong> If you are on a different hosting company, I cannot guarantee this tutorial will work for you (though it may be helpful in figuring out your issues). As always, before you make changes to critical files (<span class="file">http.conf</span>, <span class="file">.bashrc</span>, <abbr lang="la" title="et cetera meaning &#8220;and so forth&#8221;">etc.</abbr>), do yourself a favor and make a backup copy; this tutorial offers assistance, but no warranty, so if you mess something up during the install, you&#8217;re on your own (but Westhost tech support should be helpful). Finally, this tutorial assumes some familiarity with the <em>Site Manager</em> from Westhost and some basic knowledge of the Linux shell.</p>
  <p>Now that I&#8217;ve had to muddle through it a few times, I decided that, for my own sanity and to aid anyone else out there who may be going through the same thing, I would put together a comprehensive tutorial on how to install <a href="http://www.rubyonrails.com">Ruby on Rails</a> at <a href="http://www.westhost.com">Westhost</a>. The major problems that arise and could trip you up are</p>
<ol>
  <li>Westhost runs <a href="http://www.apache.org">Apache 1.3</a>,</li>
  <li><a href="http://www.fastcgi.com">Fast<abbr title="Common Gateway Interface">CGI</abbr></a> is not installed (and Rails will run incredibly slow without it), and</li>
  <li>you cannot install applications in <em class="path">/usr/bin</em>.</li>
</ol>
  <p>This tutorial will get you up and running with a very simple Rails page on your Westhost <abbr title="Virtual Private Server">VPS</abbr> server using Apache 1.3 with Fast<abbr title="Common Gateway Interface">CGI</abbr>. For simplicity&#8217;s sake, I am going to set up the test Rails <abbr title="application">app</abbr> on its own hostname (<em class="url">demo.yoursitehere.com</em>).</p>
  
  <h2>Required Site Applications</h2>
  <p>Before we get started, log into your <em>Site Manager</em> (it can be found at <em class="url">http://www.yoursitehere.com/manager</em>) and make sure the following are installed:</p>
  <ul>
    <li>MySQL 4.1.9 &#8211; because you&#8217;ll want a database</li>
    <li>GNU Compiler Collection 1.0 &#8211; because we&#8217;ve got some compiling to do</li>
  </ul>
  <p>While you&#8217;re there, under <em>Domain Management</em>, set up a new hostname for your domain using the following values:</p>
  <ul>
    <li>hostname: <em>demo</em></li>
    <li>path: <em class="path">/var/www/demo</em></li>
  </ul>
  <p>Now <abbr title="secure shell">SSH</abbr> into your site and we can get started.</p>

  <h2 id="step_1">Step 1: Collect &#38; unpack</h2>
  <p>First of all, make sure you are in your home directory</p>
  <pre class="shell">[~]$ cd /home/your_username</pre>
  <p>and then we can start the downloading and unpacking. First we get Ruby (the latest is 1.8.3 as of this writing)</p>
  <pre class="shell">[~]$ wget http://rubyforge.org/frs/download.php/6155/ruby-1.8.3.tar.gz
[~]$ tar -xvzf ruby-1.8.3.tar.gz
[~]$ rm -f ruby-1.8.3.tar.gz</pre>
  <p>Next up is the latest Ruby Gem Manager (version 0.8.11 at present)</p>
  <pre class="shell">[~]$ wget http://rubyforge.org/frs/download.php/5207/rubygems-0.8.11.tgz
[~]$ tar -xvzf rubygems-0.8.11.tgz
[~]$ rm -f rubygems-0.8.11.tgz</pre>
  <p>then the latest Fast<abbr title="Common Gateway Interface">CGI</abbr> Developer&#8217;s Kit (version 2.4.0 at present)</p>
<pre class="shell">[~]$ wget http://www.fastcgi.com/dist/fcgi-2.4.0.tar.gz
[~]$ tar -xvzf fcgi-2.4.0.tar.gz
[~]$ rm -f fcgi-2.4.0.tar.gz</pre>
  <p>and, finally, the Fast<abbr title="Common Gateway Interface">CGI</abbr> module for Apache (version 2.4.2 at present)</p>
  <pre class="shell">[~]$ wget http://www.fastcgi.com/dist/mod_fastcgi-2.4.2.tar.gz
[~]$ tar -xvzf mod_fastcgi-2.4.2.tar.gz
[~]$ rm -f mod_fascgi-2.4.2.tar.gz</pre>

  <h2 id="step_2">Step 2: Configure &#38; Install Ruby</h2>
  <p>Starting in your home directory, get into the Ruby folder</p>
  <pre class="shell">[~]$ cd ruby-1.8.3</pre>
We need to configure the source before we compile, letting it know that Ruby will be installed in <em class="path">/usr/local/ruby</em> instead of <em class="path">/usr/local</em>:</p>
  <pre class="shell">[ruby-1.8.3]$ ./configure --prefix=/usr/local/ruby</pre>
  <p>Then go ahead and create the makefile and install Ruby.</p>
  <pre class="shell">[ruby-1.8.3]$ make &#38;&#38; make install</pre>
  <p>As we will be working with Ruby from the command line, we need it as part of our <var>PATH</var>, which means editing our <span class="file">.bashrc</span> file:</p>
  <pre class="shell">[ruby-1.8.3]$ pico /.bashrc</pre>
  <p>looking a few lines down from the top, you will see this line</p>
  <blockquote><p><code>export PATH=&#34;$PATH:/usr/local/apache/bin&#34;</code></p></blockquote>
  <p>Change it to read</p>
  <blockquote><p><code>export PATH=&#34;$PATH:/usr/local/apache/bin:/usr/local/ruby/bin&#34;</code></p></blockquote>
  <p>and save as you exit. Make sure your current session is using the new .bashrc file and then check your Ruby version (which will tell us if Ruby is working):</p>
  <pre class="shell">[ruby-1.8.3]$ source /.bashrc
[ruby-1.8.3]$ ruby -v
ruby 1.8.3 (2005-9-21) [i686-linux]</pre>
  <p>Return to your home directory</p>
  <pre class="shell">[ruby-1.8.3]$ cd ..</pre>

  <h2 id="step_3">Step 3: Installing Ruby Gem Manager</h2>
  <p>We will be using the Ruby Gem Manager to install pretty much every other Ruby or Rails component we need, so it is next on our list. First of all, enter its folder</p>
  <pre class="shell">[~]$ cd rubygems-0.8.11</pre>
  <p>and then install it using Ruby</p>
  <pre class="shell">[rubygems-0.8.11]$ ruby setup.rb</pre>
  <p>So now we have the Gem Manager installed, but you&#8217;ll notice that typing gem at the prompt gives you an error that the system doesn&#8217;t know which interpreter to use for gem. We need to fix the gem bang line:</p>
  <pre class="shell">[rubygems-0.8.11]$ pico /usr/local/ruby/bin/gem</pre>
  <p>Change the first line to read</p>
  <blockquote><p><code>#!/usr/local/ruby/bin/ruby</code></p></blockquote>
  <p>Save your work when you exit and give gem a test run</p>
  <pre class="shell">[rubygems-0.8.11]$ gem list</pre>
  <p>We don&#8217;t have any gems installed yet, but that&#8217;s what we&#8217;re doing next.</p>

  <h2 id="step_4">Step 4: Install Rails</h2>
  <p>Now that we have the Gem Manager installed, the rest of the basic stuff is a snap. To install Rails, simply type the following</p>
  <pre class="shell">[rubygems-0.8.11]$ gem install rails --include-dependencies</pre>
  <p>This could take a little while, but should complete within a few minutes. In that short time, you can decide on the type of markup shorthand you&#8217;d like to work with (if any). <a href="http://textism.com/tools/textile/">Textile</a> is a pretty popular one, but <a href="http://daringfireball.net/projects/markdown/">Markdown</a> has its fans too. You could always go for both, but that seems a tad gluttonous.</p>
  <p>If you want Textile, enter the following:</p>
  <pre class="shell">[rubygems-0.8.11]$ gem install RedCloth</pre>
  <p>If you want Markdown enter the following:</p>
  <pre class="shell">[rubygems-0.8.11]$ gem install BlueCloth</pre>
  <p>That was easy, but we&#8217;re not out of the woods yet. Unfortunately for us, Ruby 1.8.3 and the latest Rails (0.9.2 at present) do not see eye to eye on a certain format, but that&#8217;s okay, there&#8217;s an <a href="http://dev.rubyonrails.com/attachment/ticket/2245/as_clean_logger_rb-fixed.patch">easy fix</a>. In Ruby 1.8.3, &#8220;Format&#8221; is not defined, so we need to fix ActiveSupport&#8217;s <span class="file">clean_logger.rb</span>. Traverse the system to get to the file (this can be done in a single command, but I broke it up for legibility):</p>
  <pre class="shell">[rubygems-0.8.11]$ cd /usr/local/ruby/lib/ruby/gems/1.8/gems/
[gems]$ activesupport-1.1.1/lib/active_support/
[active_support]$ pico clean_logger.rb</pre>
  <p>Toward the bottom of this file, you will see the following</p>
  <blockquote><pre class="ruby"><code>  private
    remove_const &#34;Format&#34;
    Format = &#34;%s\n&#34;
    def format_message(severity, timestamp, msg, progname)
      Format % [msg]
    end</code></pre></blockquote>
  <p>As &#8220;Format&#8221; is not defined, we need to test for it before removing. To do this, change that section to read</p>
  <blockquote><pre class="ruby"><code>  private
    <strong>if const_defined?(:Format) # Not defined in Ruby 1.8.3
      remove_const &#34;Format&#34;
    end</strong>
    Format = &#34;%s\n&#34;
    def format_message(severity, timestamp, msg, progname)
      Format % [msg]
    end</code></pre></blockquote>
  <p>Now that we&#8217;ve done that, we can test our Rails install:</p>
  <pre class="shell">[active_support]$ cd /var/www
[www]$ rails demo
[www]$ cd demo
[demo]$ ruby script/server</pre>
  <p>Open web browser to <em class="url">http://www.yoursitehere.com:3000/</em> and look what you did. Congratulations, you&#8217;ve put Ruby on Rails!
  
  <h2 id="step_5">Step 5: Getting Fast<abbr title="Common Gateway Interface">CGI</abbr> up on Apache 1.3</h2>
  <p>OK, all of that stuff was pretty easy, but know things get just a little more complex. If you don&#8217;t want to run Rails through Apache (and there are plenty of reasons not to), feel free to stop now, but if you would like Rails to run like the rest of your sites, keep reading, but be warned that it gets very tedious from here on in.</p>
  <p>First off, return to your home directory:</p>
  <pre class="shell">[demo]$ cd /home/your_username</pre>
  <p>We need to install the Fast<abbr title="Common Gateway Interface">CGI</abbr> <abbr title="Development">Dev</abbr> Kit. To do that, enter its directory, configure and install it similarly to how we did Ruby:</p>
  <pre class="shell">[~]$ cd fcgi-2.4.0
[fcgi-2.4.0]$ ./configure --prefix=/usr/local/fcgi
[fcgi-2.4.0]$ make &#38;&#38; make install</pre>
  <p>Next on the agenda is getting Apache to understand Fast<abbr title="Common Gateway Interface">CGI</abbr>. To do this, we need to compile and install the <abbr title="Dynamic Shared Object">DSO</abbr> for Apache, which uses a slightly different process:</p>
  <pre class="shell">[fcgi-2.4.0]$ cd ..
[~]$ cd mod_fastcgi-2.4.2
[mod_fastcgi-2.4.2]$ apxs -o mod_fastcgi.so -c *.c
[mod_fastcgi-2.4.2]$ apxs -i -a -n fastcgi mod_fastcgi.so</pre>
  <p>That put Fast<abbr title="Common Gateway Interface">CGI</abbr> in Apache&#8217;s <span class="file">httpd.conf</span> file, but it&#8217;s likely going to be in the wrong place, so we&#8217;ll need to edit it.</p>
  <pre class="shell">[mod_fastcgi-2.4.2]$ pico /etc/httpd/conf/httpd.conf</pre>
  <p>Most likely the install placed the <code>LoadModule</code> for Fast<abbr title="Common Gateway Interface">CGI</abbr> inside the <code>HAVE_FRONTPAGE_SPHERA</code> block:</p>
  <blockquote><pre class="apache"><code>&#60;IfDefine HAVE_FRONTPAGE_SPHERA&#62;
  LoadModule frontpage_module  modules/mod_frontpage_sphera.so
  LoadModule fastcgi_module    /usr/lib/apache/mod_fastcgi.so
&#60;/IfDefine&#62;</code></pre></blockquote>
  <p>We need to change that to read</p>
  <blockquote><pre class="apache"><code>&#60;IfDefine HAVE_FRONTPAGE_SPHERA&#62;
  LoadModule frontpage_module  modules/mod_frontpage_sphera.so
&#60;/IfDefine&#62;
LoadModule fastcgi_module   /usr/lib/apache/mod_fastcgi.so</code></pre></blockquote>
  <p>A little further down, we need to do the same to the <code>AddModule</code> statement:</p>
  <blockquote><pre class="apache"><code>&#60;IfDefine HAVE_FRONTPAGE_SPHERA>
  AddModule mod_frontpage_sphera.c
  AddModule mod_fastcgi.c
&#60;/IfDefine&#62;</code></pre></blockquote>
becomes
  <blockquote><pre class="apache"><code>&#60;IfDefine HAVE_FRONTPAGE_SPHERA>
  AddModule mod_frontpage_sphera.c
&#60;/IfDefine&#62;
AddModule mod_fastcgi.c</code></pre></blockquote>
  <p>We then need to add the handler for Fast<abbr title="Common Gateway Interface">CGI</abbr>, so scroll down until you see some other <code>AddHandler</code> statements (or run a search) and insert the following:</p>
  <blockquote><pre class="apache"><code>AddHandler fastcgi-script fcg fcgi fpl</code></pre></blockquote>
  <p>Finally, create an instance of our demo app near the bottom of the <span class="file">httpd.conf</span> file:</p>
  <blockquote><pre class="apache"><code><strong># FastCGI
&#60;IfModule mod_fastcgi.c&#62;
  FastCgiIpcDir /tmp/fcgi_ipc
  FastCgiServer /var/www/demo/public/dispatch.fcgi
  <img src="/images/code/from-previous-line.png" width="13" height="8" alt="[continues from previous line]" /> -initial-env RAILS_ENV=development -processes 1 -idle-timeout 60
  #FastCgiServer /var/www/demo/public/dispatch.fcgi
  <img src="/images/code/from-previous-line.png" width="13" height="8" alt="[continues from previous line]" /> -initial-env RAILS_ENV=production -processes 1 -idle-timeout 60
&#60;/IfModule&#62;</strong>

&#60;VirtualHost *&#62;</code></pre></blockquote>
  <p>You&#8217;ll notice I have a commented line for the production environment, when the site is ready to go out of development and into production, you just comment out the first line and uncomment the second line and you are good to go. Note: I do not recommend developing and deploying on the same box.</p>
  <p id="disclaimer"><strong>Processes:</strong> Why only one process? Well, 1 is usually enough for most applications. If you are getting <em>really heavy</em> traffic, you could bump it up to 2, but Fast<abbr title="Common Gateway Interface">CGI</abbr> can be a bit resource hungry. It is even worse if you run multiple Fast<abbr title="Common Gateway Interface">CGI</abbr> servers on a single box. For instance, according to a tech at WestHost, 4 server instances running a large number of processes (say 15) each will frequently cause over 400<abbr title="megabytes">MB</abbr> of <abbr title="Random Access Memory">RAM</abbr> and 1<abbr title="gigabyte">GB</abbr> of swap to be used on the server, resulting in the cyclic behavior of freeing and reallocating memory. This is <em>very</em> resource intensive and it causes the server&#8217;s load to spike, which is problematic for any other users on the same server (in a <abbr title="Virtual Private Server">VPS</abbr> situation).</p>
  <p>Last, but not least, configure your virtual host so that</p>
  <blockquote><pre class="apache"><code>&#60;VirtualHost *&#62;
    ServerName demo.mysite.com
    ServerAlias www.demo.mysite.com
    DocumentRoot /var/www/demo/
&#60;/VirtualHost&#62;</code></pre></blockquote>
  <p>becomes</p>
  <blockquote><pre class="apache"><code>&#60;VirtualHost *&#62;
    ServerName demo.mysite.com
    ServerAlias www.demo.mysite.com
    <strong>DocumentRoot /var/www/demo/public/
    ErrorLog /var/www/demo/log/server.log
    &#60;Directory /var/www/demo/public/&#62;
      Options ExecCGI FollowSymLinks
      AllowOverride all
      Allow from all
      Order allow,deny
    &#60;/Directory&#62;</strong>
&#60;/VirtualHost&#62;</code></pre></blockquote>
  <p>Save the file as you exit and then test it to make sure you didn&#8217;t screw anything up before restarting Apache:</p>
  <pre class="shell">[mod_fastcgi-2.4.2]$ apachectl configtest
Syntax OK
[mod_fastcgi-2.4.2]$ apachectl restart</pre>
  <p>Hang in there, we&#8217;re almost done. To set up Rails to use Fast<abbr title="Common Gateway Interface">CGI</abbr>, we need to edit the <span class="file">.htaccess</span> file in your public folder:</p>
  <pre class="shell">[mod_fastcgi-2.4.2]$ pico /var/www/demo/public/.htaccess</pre>
  <p>In that file, change</p>
  <blockquote><pre class="apache"><code>RewriteRule ^(.*)$ dispatch.cgi [QSA,L]</code></pre></blockquote>
  <p>to read</p>
  <blockquote><pre class="apache"><code>RewriteRule ^(.*)$ <strong>dispatch.fcgi</strong> [QSA,L]</code></pre></blockquote>
  <p>Then save when you exit.</p>
  <p>Finally, we need to set up the Ruby-Fast<abbr title="Common Gateway Interface">CGI</abbr> Gem</p>
  <pre class="shell">[mod_fastcgi-2.4.2]$ gem install fcgi -- --with-fcgi-dir=/usr/local/fcgi</pre>
  <p>Once that&#8217;s done, edit the <span class="file">dispatch.fcgi</span> file in your public directory</p>
  <pre class="shell">[mod_fastcgi-2.4.2]$ pico /var/www/demo/public/dispatch.fcgi</pre>
  <p>to use the Gem by changing</p>
  <blockquote><pre class="ruby"><code>require File.dirname(__FILE__) + &#34;/../config/environment&#34;
require 'fcgi_handler'</code></pre></blockquote>
  <p>to</p>
  <blockquote><pre class="ruby"><code><strong>require 'rubygems'
require_gem 'fcgi'</strong>
require File.dirname(__FILE__) + &#34;/../config/environment&#34;
require 'fcgi_handler'</code></pre></blockquote>
  
  <h2 id="step_6">Step 6: Let&#8217;s get rolling</h2>
  <p>Finally we are in a position to test our install. To do so, we&#8217;ll add a simple controller to our demo Rails install. We start by moving into the demo folder</p>
  <pre class="shell">[mod_fastcgi-2.4.2]$ cd /var/www/demo</pre>
  <p>and then we use the Generator to make us a controller:</p>
  <pre class="shell">[demo]$ ruby script/generate controller Say</pre>
  <p>That doesn&#8217;t do a whole lot since we have no actions. Let&#8217;s define an empty one:</p>
  <pre class="shell">[demo]$ pico app/controllers/say_controller.rb</pre>
  <p>Edit the file to read</p>
  <blockquote><pre class="ruby"><code>class SayController &#60; ApplicationController
  <strong>def hello
  end</strong>
end</code></pre></blockquote>
  <p>and save as you exit.</p>
  <p>Now that&#8217;s all well and good, but we get an error if we try to surf to <em class="url">http://demo.yoursitehere.com/say/hello</em> because there is no view associated with it. That&#8217;s easy enough to remedy, we&#8217;ll create one.</p>
  <pre class="shell">[demo]$ pico app/views/say/hello.rhtml</pre>
  <p>Type out something simple, such as</p>
  <pre class="rhtml"><code>&#60;html&#62;
  &#60;head&#62;
    &#60;title&#62;Hello World&#60;/title&#62;
  &#60;/head&#62;
  &#60;body&#62;
    &#60;h1&#62;Hello from Rails!&#60;/h1&#62;
    &#60;p&#62;The current time is &#60;%= Time.now %&#62;&#60;/p&#62;
  &#60;/body&#62;
&#60;/html&#62;</code></pre>
  <p>and then revisit <em class="url">http://demo.yoursitehere.com/say/hello</em>. Now you&#8217;re rolling. Good luck and enjoy.</p>
  
  <h2 id="addendum">Addendum: What? You want MySQL?</h2>
  <p>Okay, so you want to hook up Rails to your MySQL database now. To do this, there&#8217;s a few hoops you need to jump though. First of all, you&#8217;ll need to edit your database configuration file.</p>
  <pre class="shell">[demo]$ pico config/database.yml</pre>
  <p>Fill in your database names for the development, test and production environments and the username and password for each. Then add the socket path:</p>
  <pre class="yml"><code>development:
  adapter: mysql
  <strong>socket: /var/lib/mysql/mysql.sock</strong>
  database: <em>your_development_db</em>
  host: localhost
  username: root
  password: <em>your_password</em>

# Warning: The database defined as 'test' will be erased and
# re-generated from your development database when you run 'rake'.
# Do not set this db to the same as development or production.
test:
  adapter: mysql
  <strong>socket: /var/lib/mysql/mysql.sock</strong>
  database: <em>your_test_db</em>
  host: localhost
  username: root
  password: <em>your_password</em>

production:
  adapter: mysql
  <strong>socket: /var/lib/mysql/mysql.sock</strong>
  database: <em>your_production_db</em>
  host: localhost
  username: root
  password: <em>your_password</em></code></pre>
  <p>and save as you exit. Without the socket information, Rails will never find MySQL, which sucks.</p>
  <p>Finally, to overcome <a href="http://wiki.rubyonrails.org/rails/pages/MySQL+Database+access+problem">the backward-compatible password issue between Rails and MySQL</a>, you need to install the latest MySQL Gem. Unfortunately this is easier said than done. First off, you run the install as you&#8217;d expect:</p>
  <pre class="shell">[demo]$ gem install mysql</pre>
  <p>and it spits back an error. Luckily it leaves the files where you can get to them. At present the latest version of the MySQL Gem is 2.6, so</p>
  <pre class="shell">[demo]$ cd /usr/local/ruby/lib/ruby/gems/1.8/gems/mysql-2.6</pre>
  <p>The error is because MySQL cannot be found in the regular location. We need to add a configuration parameter</p>
  <pre class="shell">[mysql-2.6]$ ruby extconf.rb --with-mysql-dir=/usr/local/mysql</pre>
  <p>and then finally</p>
  <pre class="shell">[mysql-2.6]$ make &#38;&#38; make install</pre>
  <p>And you&#8217;re good to go.</p>
  
  <div id="extras">
    <h2>Resources</h2>
    <ul>
      <li><a href="http://wiki.rubyonrails.org">Ruby on Rails Wiki</a></li>
      <li><a href="http://www.amazon.com/exec/obidos/redirect?path=ASIN/097669400X&link_code=as2&camp=1789&tag=easydesign-20&creative=9325"><cite>Agile Web Development with Rails</cite></a></li>
    </ul>
    <h2>Questions/Comments</h2>
    <p>I will be happy to take any questions or comments about this tutorial in <a href="http://www.easy-reader.net/archives/2005/10/02/new-tutorial-westhost-on-rails/">it&#8217;s associated blog entry</a>.</p>
  </div>
</div>
<?php foot(); ?>

</body>
</html>