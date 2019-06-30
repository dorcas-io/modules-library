@extends('layouts.tabler')

@section('body_content_header_extras')
<!-- <div class="page-subtitle">1 - 12 of 1713 photos</div> -->
<div class="page-options d-flex" id="library_switcher">
    <select class="form-control custom-select w-auto" v-on:change="changeCategory($event)" id="library_switch_category" v-model="selectedCategory">
        @foreach ($categories as $ck => $cv)
            <option value="{{ $cv['id'] }}">{{ $cv["name"] }}</option>
        @endforeach
    </select>
    <select class="form-control custom-select w-auto" v-on:change="changeSubCategory($event)" id="library_switch_subcategory" v-model="selectedSubCategory">
        @foreach ($subcategories as $sk => $sv)
            <option value="{{ $sv['id'] }}">{{ $sv["name"] }}</option>
        @endforeach
    </select>
    <!-- <div class="input-icon ml-2">
        <span class="input-icon-addon">
            <i class="fe fe-search"></i>
        </span>
        <input type="text" class="form-control w-10" placeholder="Search photo">
    </div> -->
</div>
@endsection

@section('body_content_main')

@include('layouts.blocks.tabler.alert')

<div class="row">
    @include('layouts.blocks.tabler.sub-menu')

    <div class="col-md-9 col-xl-9">

        <div class="container" id="listing_videos">
            <div class="row mt-3" style="display: flex !important;" v-if="showVideos">
                <!-- <library-video-card class="s12 m4" v-for="video in videos" :key="video.id" :video="video" v-on:watch-video="watchVideo"></library-video-card> -->
                <div class="col-md-6" v-for="video in videos" :key="video.id" :video="video">
                  <div class="card p-3">
                    <a href="javascript:void(0)" class="mb-3">
                      <img v-bind:src="video.resource_thumb" v-bind:alt="video.resource_title" class="rounded" data-resource-id="" v-bind:data-resource-source="video.resource_source" v-on:click.prevent="watchVideo(video.id)">
                    </a>
                    <div class="d-flex align-items-center px-2">
                      <div class="avatar avatar-md mr-3" v-bind:style="{ 'background-image': 'url(' + video.resource_thumb + ')' }"></div>
                      <div>
                        <small class="d-block text-muted">@{{ video.resource_title }}</small>
                      </div>
                      <!-- <div class="ml-auto text-muted">
                        <a href="#" v-on:click.prevent="watchVideo(video.id)" data-resource-id="" v-bind:data-resource-source="video.resource_source" class="icon"><i class="fe fe-eye mr-1"></i></a>
                        <a href="#" data-resource-id="" data-resource-source="" class="icon d-none d-md-inline-block ml-3"><i class="fe fe-heart mr-1"></i></a>
                      </div> -->
                    </div>
                  </div>
                </div>

            </div>
            @include('modules-library::modals.viewer_video')
            <div class="col s12" v-if="!showVideos">
                @component('layouts.blocks.tabler.empty-fullpage')
                    @slot('title')
                        No Videos
                    @endslot
                    Please select from another <strong>category</strong> or <strong>sub-category</strong> above
                    @slot('buttons')
                        
                    @endslot
                @endcomponent
            </div>
        </div>

    </div>

</div>

@endsection

@section('body_js')
    <script type="text/javascript">
        var vm = new Vue({
            el: '#listing_videos',
            data: {
                videos: {!! json_encode(!empty($videos) ? $videos : []) !!},
                video: []
            },
            computed: {
                showVideos: function() {
                    if (Array.isArray(this.videos)) {
                      return this.videos.length > 0
                    } else {
                      return Object.keys(this.videos).length > 0;
                    }
                }
            },
            methods: {
                watchVideo: function (id) {
                    //let video = typeof this.videos[index] !== 'undefined' ? this.videos[index] : null;

                    var vide;

                    if (Array.isArray(this.videos)) {
                      var video = this.videos.find( vid => vid.id===id );
                      this.video = video;
                      //console.log(video)
                      vide = video
                    } else {
                      var video = Object.keys(this.videos).find(key => this.videos[key].id === id);
                      this.video = this.videos[video];
                      //console.log(this.videos[video])
                      vide = this.videos[video]
                    }
                    
                    /*if (this.video === null) {
                        return;
                    }
                    //console.log(video);
                    this.video = video;*/
                    $('#player-video-modal').modal('show');

                    $('#player-video-modal').on('shown.bs.modal', function (e) {
                      $("#library-resource-video").attr('src', vide.resource_video + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0&amp;rel=0" );
                      var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
                      let resource_linked = vide.resource_description.replace(exp, "<a target=\"_blank\" href='$1'>$1</a>");
                      $("#library-resource-description").html(resource_linked);
                    });
                    $('#player-video-modal').on('hide.bs.modal', function (e) {
                      $("#library-resource-video").attr('src', vide.resource_video );
                    });
                }
            },
            mounted: function() {
                //console.log(this.videos)
                //console.log(Array.isArray(this.videos))
            }
        });

        var library_switcher_vm = new Vue({
            el: '#library_switcher',
            data: {
                categories: {!! json_encode(!empty($categories) ? $categories : []) !!},
                subcategories: {!! json_encode(!empty($subcategories) ? $subcategories : []) !!},
                selectedCategory : {{ $selectedCategory }},
                selectedSubCategory : {{ $selectedSubCategory }},
            },
            computed: {
              library_switch_category_selected: {
                get () {
                  return null;
                },
                set (optionValue) {
                  //this.options = this.options.filter(o => o !== optionValue);
                  console.log(this.options)
                },
              },
            },
            methods:{
              changeCategory:function(event){
                //console.log(this.selectedCategory);
                //console.log(event.target.value);
                var changeParams = '?cat=' + this.selectedCategory + '&subcat=' + this.selectedSubCategory;
                var cat_index = event.target.selectedIndex;
                let subcat_text = $("#library_switch_subcategory option:selected").text();
                let timerInterval
                Swal.fire({
                  html: 'Switching to videos labelled <strong>' + subcat_text + '</strong> in <strong>' + event.target[cat_index].text + '</strong>',
                  type: 'info',
                  allowOutsideClick: () => !Swal.isLoading(),
                  timer: 10000,
                  onBeforeOpen: () => {
                    Swal.showLoading()
                    timerInterval = setInterval(() => {
                       if (Swal.getTimerLeft()<8000) {
                        //Swal.stopTimer()
                        window.location = '{{ route("library-videos") }}' + changeParams
                       }
                    }, 100)
                  }
                });
              },
              changeSubCategory:function(event){
                //console.log(this.selectedSubCategory);
                //console.log(event.target.value);
                var changeParams = '?cat=' + this.selectedCategory + '&subcat=' + this.selectedSubCategory;
                var subcat_index = event.target.selectedIndex;
                let cat_text = $("#library_switch_category option:selected").text();
                let timerInterval
                Swal.fire({
                  html: 'Switching to videos labelled <strong>' + event.target[subcat_index].text + '</strong> in <strong>' + cat_text + '</strong>',
                  type: 'info',
                  allowOutsideClick: () => !Swal.isLoading(),
                  timer: 10000,
                  onBeforeOpen: () => {
                    Swal.showLoading()
                    timerInterval = setInterval(() => {
                       if (Swal.getTimerLeft()<8000) {
                        //Swal.stopTimer()
                        window.location = '{{ route("library-videos") }}' + changeParams
                       }
                    }, 100)
                  }
                });
              }
            }
        });

    </script>
@endsection