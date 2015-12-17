<!doctype html>
<!--
@license
Copyright (c) 2015 The Polymer Project Authors. All rights reserved.
This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
Code distributed by Google as part of the polymer project is also
subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
-->

<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="generator" content="Polymer Starter Kit" />
  <title>AMACC Naga E-Learning Hub</title>
  <!-- Place favicon.ico in the `app/` directory -->

  <!-- Chrome for Android theme color -->
  <meta name="theme-color" content="#2E3AA1">

  <!-- Web Application Manifest -->
  <link rel="manifest" href="manifest.json">

  <!-- Tile color for Win8 -->
  <meta name="msapplication-TileColor" content="#3372DF">

  <!-- Add to homescreen for Chrome on Android -->
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="application-name" content="PSK">
  <link rel="icon" sizes="192x192" href="images/touch/chrome-touch-icon-192x192.png">

  <!-- Add to homescreen for Safari on iOS -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="apple-mobile-web-app-title" content="Polymer Starter Kit">
  <link rel="apple-touch-icon" href="images/touch/apple-touch-icon.png">

  <!-- Tile icon for Win8 (144x144) -->
  <meta name="msapplication-TileImage" content="images/touch/ms-touch-icon-144x144-precomposed.png">

  <!-- build:css styles/main.css -->
  <link rel="stylesheet" href="styles/main.css">
  <!-- endbuild-->

  <!-- build:js bower_components/webcomponentsjs/webcomponents-lite.min.js -->
  <script src="bower_components/webcomponentsjs/webcomponents-lite.js"></script>
  <!-- endbuild -->

  <!-- will be replaced with elements/elements.vulcanized.html -->
  <link rel="import" href="elements/elements.html">
  <!-- endreplace-->

  <!-- For shared styles, shared-styles.html import in elements.html -->
  <style is="custom-style" include="shared-styles"></style>

</head>

<body unresolved class="fullbleed layout vertical">
  <span id="browser-sync-binding"></span>
  <template is="dom-bind" id="app">

    <template is="dom-if" if="@{{ isAuthenticated() }}">    
      <paper-drawer-panel id="paperDrawerPanel">
        <!-- Drawer Scroll Header Panel -->
        <paper-scroll-header-panel drawer fixed>

          <!-- Drawer Toolbar -->
          <paper-toolbar id="drawerToolbar">
            <span class="paper-font-title">Menu</span>
          </paper-toolbar>

          <!-- Drawer Content -->
          <paper-menu class="list" attr-for-selected="data-route" selected="[[route]]">
            <a data-route="home" href="/" on-click="onDataRouteClick">
              <iron-icon icon="home"></iron-icon>
              <span>Home</span>
            </a>

            <template is="dom-if" if="@{{ isAdmin() }}">
              <a data-route="student" href="/students" on-click="onDataRouteClick">
                <iron-icon icon="info"></iron-icon>
                <span>Students</span>
              </a>

              <a data-route="teacher" href="/teachers" on-click="onDataRouteClick">
                <iron-icon icon="mail"></iron-icon>
                <span>Teachers</span>
              </a>

              <a data-route="settings" href="/settings" on-click="onDataRouteClick">
                <iron-icon icon="settings"></iron-icon>
                <span>Settings</span>
              </a>            
            </template>

            <template is="dom-if" if="@{{ isTeacher() }}">
              <a data-route="subject" href="/subjects" on-click="onDataRouteClick">
                <iron-icon icon="settings"></iron-icon>
                <span>My Subjects</span>
              </a>

              <a data-route="student" href="/students" on-click="onDataRouteClick">
                <iron-icon icon="mail"></iron-icon>
                <span>My Students</span>
              </a>

              <a data-route="settings" href="/settings" on-click="onDataRouteClick">
                <iron-icon icon="settings"></iron-icon>
                <span>Settings</span>
              </a>
            </template>

            <template is="dom-if" if="@{{ isStudent() }}">
              <a data-route="subject" href="/subjects" on-click="onDataRouteClick">
                <iron-icon icon="assessment"></iron-icon>
                <span>My Subjects</span>
              </a>

              <a data-route="quiz" href="/quiz" on-click="onDataRouteClick">
                <iron-icon icon="assignment"></iron-icon>
                <span>My Quizzes</span>
                <span class="notif">@{{ notif.response }}</span>
              </a>

              <a data-route="settings" href="/settings" on-click="onDataRouteClick">
                <iron-icon icon="settings"></iron-icon>
                <span>Settings</span>
              </a>    
            </template>
          </paper-menu>
        </paper-scroll-header-panel>

        <!-- Main Area -->
        <paper-scroll-header-panel main condenses keep-condensed-header>

          <!-- Main Toolbar -->
          <paper-toolbar id="mainToolbar" class="tall">
            <paper-icon-button id="paperToggle" icon="menu" paper-drawer-toggle></paper-icon-button>
            <span class="flex"></span>

            <!-- Toolbar icons -->

              <!-- Application name -->
            <div class="middle middle-container center horizontal layout">
              <div class="app-name">AMACC Naga E-Learning Hub</div>
            </div>

            <!-- Application sub title -->
            <div class="bottom bottom-container center horizontal layout">
              <div class="bottom-title paper-font-subhead">AMA Computer College Naga</div>
            </div>

          </paper-toolbar>

          <!-- Main Content -->
          <div class="content">
            <iron-pages attr-for-selected="data-route" selected="@{{route}}">

              <section data-route="home">
                <template is="dom-if" if="@{{ isAdmin() }}">
                  <admin-home-page></admin-home-page>
                </template>

                <template is="dom-if" if="@{{ isTeacher() }}">
                  <teachers-home-page></teachers-home-page>
                </template>

                <template is="dom-if" if="@{{ isStudent() }}">
                  <students-home-page></students-home-page>
                </template>

              </section>

              <section data-route="users">
                <paper-material elevation="1">
                  <h2 class="page-title">Users</h2>
                  <p>This is the users section</p>
                  <a href="/users/Rob">Rob</a>
                </paper-material>
              </section>

              <section data-route="user-info">
                <paper-material elevation="1">
                  <h2 class="page-title">
                  User:<span>@{{params.name}}</span>
                  </h2>
                  <div>This is <span>@{{params.name}}</span>'s section</div>
                </paper-material>
              </section>

              <section data-route="contact">
                <paper-material elevation="1">
                  <h2 class="page-title">Contact</h2>
                  <p>This is the contact section</p>
                </paper-material>
              </section>

              <section data-route="subject">
                <template is="dom-if" if="@{{ isTeacher() }}">
                  <teacher-subjects-page></teacher-subjects-page>
                </template>

                <template is="dom-if" if="@{{ isStudent() }}">
                  <students-subject-page></students-subject-page>
                </template>
              </section>

              <section data-route="subject-section">
                <template is="dom-if" if="@{{ isTeacher() }}">
                  <teacher-subjects-page-view subject-id="@{{ params.id }}">
                  </teacher-subjects-page-view>
                </template>

                <template is="dom-if" if="@{{ isStudent() }}">
                  <students-subject-page-view subject-id="@{{ params.id }}">
                  </students-subject-page-view>
                </template>
              </section>

              <section data-route="student">
                <template is="dom-if" if="@{{ isAdmin() }}">
                  <admin-students-page></admin-students-page>
                </template>

                <template is="dom-if" if="@{{ isTeacher() }}">
                  <teacher-students-page></teacher-students-page>
                </template>
              </section>

              <section data-route="teacher">
                <template is="dom-if" if="@{{ isAdmin() }}">
                  <admin-teachers></admin-teachers>
                </template>
              </section>

              <section data-route="settings">
                <template is="dom-if" if="@{{ isAdmin() }}">
                  <admin-settings></admin-settings>
                </template>

                <template is="dom-if" if="@{{ isTeacher() }}">
                  <change-password></change-password>
                </template>

                <template is="dom-if" if="@{{ isStudent() }}">
                  <change-password></change-password>
                </template>
              </section>

              <section data-route="quiz">
                <template is="dom-if" if="@{{ isStudent() }}">
                  <student-my-quiz></student-my-quiz>
                </template>
              </section>

              <section data-route="take-quiz">
                <template is="dom-if" if="@{{ isStudent() }}">
                <student-take-quiz quiz-id="@{{ params.id }}"></student-take-quiz>
                </template>
              </section>

              <section data-route="quiz-details">
                <quiz-details quiz-id="@{{ params.id }}"></quiz-details>
              </section>

              <section data-route="start-quiz">
                <template is="dom-if" if="@{{ isStudent() }}">
                  <quiz-start></quiz-start>
                </template>
              </section>

              <section data-route="edit-quiz">
                <template is="dom-if" if="@{{ isTeacher() }}">
                  <edit-quiz quiz-id="@{{ quizId }}"></edit-quiz>
                </template>
              </section>

              <section data-route="quiz-result">
                <template is="dom-if" if="@{{ isStudent() }}">
                  <student-quiz-result></student-quiz-result>
                </template>
              </section>


              
              <quiz-page data-route="quiz-page"></quiz-page>

            </iron-pages>
          </div>
            <paper-icon-button id="logout" title="Logout" icon="exit-to-app" on-tap="logout"></paper-icon-button>
          
        </paper-scroll-header-panel>
      </paper-drawer-panel>
    </template>
    <template is="dom-if" if="@{{ !isAuthenticated() }}">

      <paper-scroll-header-panel main condenses keep-condensed-header>
        <paper-toolbar id="mainToolbar" class="tall">
          <!-- Application name -->
          <div class="middle middle-container center horizontal layout">
            <div class="app-name">AMACC Naga E-Learning Hub</div>
          </div>

          <!-- Application sub title -->
          <div class="bottom bottom-container center horizontal layout">
            <div class="bottom-title paper-font-subhead">AMA Computer College Naga</div>
          </div>

        </paper-toolbar>

        <div class="content">
          <login-page></login-page>
        </div>
      </paper-scroll-header-panel>
      
    </template>

    <!-- Uncomment next block to enable Service Worker support (1/2) -->
    <!--
    <paper-toast id="caching-complete"
                 duration="6000"
                 text="Caching complete! This app will work offline.">
    </paper-toast>

    <platinum-sw-register auto-register
                          clients-claim
                          skip-waiting
                          on-service-worker-installed="displayInstalledToast">
      <platinum-sw-cache default-cache-strategy="fastest"
                         cache-config-file="cache-config.json">
      </platinum-sw-cache>
    </platinum-sw-register>
    -->

    <iron-ajax
        auto
        url="@{{ notifUrl() }}"
        handle-as="json"
        last-response="@{{ notif }}"
        debounce-duration="300"></iron-ajax>


  </template>

  <!-- build:js scripts/app.js -->
  <script src="scripts/app.js"></script>
  <script src="scripts/jwt-decode.min.js"></script>
  <!-- endbuild-->
</body>

</html>
