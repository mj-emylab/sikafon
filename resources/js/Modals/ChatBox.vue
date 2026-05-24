<template>
    <div>
        <div class="row">
            <span>
                <!-- <loading
                    :active="isLoading"
                    :is-full-page="false"
                    loader="bars"
                    :width="25"
                    :height="25"
                ></loading> -->
            </span>
        </div>
        <!-- start -->
        <section class="gradient-custom">
            <div class="container pt-5">

                <div class="row">

                    <div class="col-md-6 col-lg-5 col-xl-5 mb-4 mb-md-0">

                        <h5 class="font-weight-bold mb-3 text-center text-white">Chat History <i @click.prevent="addModal()" class="fa fa-plus text-danger"></i></h5>
                        
                        <div id="myDivs1" class="card mask-custom" style="height: 550px; overflow-y: auto;">
                            <div class="card-body">

                                <div class="input-group rounded mb-3">
                                    <div class="dropdown mr-3">
                                        <button type="button" class="form-control rounded" data-toggle="dropdown" data-bs-toggle="dropdown">
                                            Filter
                                        </button>
                                        <div class="dropdown-menu">
                                            <a  @click.prevent="filter(0)" class="dropdown-item"  title="All" href="#">
                                                <i class="fa fa-pencil text-green"></i> All
                                            </a>
                                            <a  @click.prevent="filter(1)" class="dropdown-item"  title="Group" href="#">
                                                <i class="fa fa-pencil text-green"></i> Group
                                            </a>
                                            <a  @click.prevent="filter(2)" class="dropdown-item"  title="From Me" href="#">
                                                <i class="fa fa-pencil text-blue"></i> From Me
                                            </a>
                                            <a  @click.prevent="filter(3)" class="dropdown-item"  title="To Me" href="#">
                                                <i class="fa fa-pencil text-blue"></i> To Me
                                            </a>
                                        </div>
                                    </div>
                                    <input v-model="value" type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                                    aria-describedby="search-addon" />
                                    <span class="input-group-text border-0" id="search-addon">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    
                                </div>
                                <ul class="list-unstyled mb-0">

                                    <li v-if="showG && getChatData.group">
                                        <div v-for="(row, index) in getChatData.group" :key="index" class="p-2 border-bottom" style="border-bottom: 1px solid rgba(255,255,255,.3) !important;">
                                            <div class="d-flex justify-content-between link-light">
                                                <div class="d-flex flex-row">

                                                    <a class="dropdown">
                                                        <!-- <span style="color: green;" class="span" data-toggle="dropdown" data-bs-toggle="dropdown">
                                                            
                                                        </span> -->
                                                        <img data-toggle="dropdown" data-bs-toggle="dropdown" :src="row.image? row.image:'assets/img/g.jpg'" alt="avatar" class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="55">
                                                        <div class="dropdown-menu">
                                                            <a v-if="checkAdmin(row.users) || row.status == 1" @click.prevent="showAddModal(row)" class="dropdown-item"  title="Make Admin" href="#">
                                                                <i class="fa fa-user text-green" style="color: green;"></i> Add User
                                                            </a>
                                                            <a v-if="row.created_by == user_id"  @click.prevent="editGroupModal(row)" class="dropdown-item"  title="Remove" href="#">
                                                                <i class="fa fa-pen text-green" style="color: blue;"></i> Edit
                                                            </a>
                                                            <a  @click.prevent="viewGroup(row)" class="dropdown-item"  title="Remove" href="#">
                                                                <i class="fa fa-eye text-green" style="color: green;"></i> View
                                                            </a>
                                                            <a v-if="row.created_by == user_id" @click.prevent="removeGroup(row)" class="dropdown-item"  title="Remove" href="#">
                                                                <i class="fa fa-trash text-red" style="color: red;"></i> Delete
                                                            </a>
                                                            <a  @click.prevent="removeGroupForMe(row)" class="dropdown-item"  title="Remove">
                                                                <i class="fa fa-trash text-red" style="color: green;"></i> Leave Group
                                                            </a>
                                                        </div>
                                                    </a>
                                                    <div @click.prevent="view(row.message)" class="pt-1">
                                                        <p class="fw-bold mb-0 text-green" style="color: brown;">{{row.name| reduceText(10, '...')}}</p>
                                                        <p v-if="row.message.replies.legth > 0" class="small text-white">{{row.message.replies[0].msg|reduceText(10, '...')}}</p>
                                                        <p v-else class="small text-white">{{row.description|reduceText(15, '...')}}</p>
                                                    </div>
                                                </div>
                                                <div class="pt-1">
                                                    <p v-if="row.message.replies.legth > 0" class="small text-white mb-1">{{row.message.replies[0].created_at|lastTime}}</p>
                                                    <p v-else class="small text-white mb-1">{{row.created_at|lastTime}}</p>
                                                    <div class="float-end">
                                                        <span @click.prevent="removeGroupForMe(row)" class="badge bg-danger "><i class="fa fa-trash"></i></span>

                                                        <span v-if="row.status == 1" class="dropdown badge bg-success">
                                                            <i data-toggle="dropdown" data-bs-toggle="dropdown" class="fa fa-share"></i>
                                                        
                                                            <div class="dropdown-menu">
                                                                <span class="dropdown-item">
                                                                    

                                                                    <a @click.prevent="shareGroup(row, 'whatsapp')" href="" class="badge bg-success" title="Share whatsapp">
                                                                        <i class="fa fa-whatsapp"></i>
                                                                    </a>
                                                                    <a @click.prevent="shareGroup(row, 'facebook')" href="" class="badge bg-primary" title="Share facebook">
                                                                        <i class="fa fa-facebook"></i>
                                                                    </a>
                                                                    <a @click.prevent="shareGroup(row, 'telegram')" href="" class="badge bg-secondary" title="Share telegram">
                                                                        <i class="fa fa-telegram"></i>
                                                                    </a>
                                                                    <a @click.prevent="shareGroup(row, 'twitter')" href="" class="badge bg-info" title="Share twitter">
                                                                        <i class="fa fa-twitter"></i>
                                                                    </a>
                                                                    <a @click.prevent="shareGroup(row, 'linkedin')" href="" class="badge bg-success" title="Share linkedin">
                                                                        <i class="fa fa-linkedin"></i>
                                                                    </a>
                                                                    <a @click.prevent="shareGroup(row, 'email')" href="" class="badge bg-danger" title="Share email">
                                                                        <i class="fa fa-envelope"></i>
                                                                    </a>
                                                                </span>
                                                                

                                                            </div>
                                                        </span>

                                                        <span v-if="row.created_by == user_id" @click.prevent="editGroupModal(row)" class="badge bg-primary"><i class="fa fa-pen"></i></span>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </li>

                                    <li v-if="showF && getChatData.from">
                                        <div v-for="(row, index) in getChatData.from" :key="index" class="p-2 border-bottom" style="border-bottom: 1px solid rgba(255,255,255,.3) !important;">
                                            <div class="d-flex justify-content-between link-light">
                                                <div class="d-flex flex-row">
                                                    <img :src="row.messageable.image? row.messageable.image:'assets/img/d.jpg'" alt="avatar"
                                                    class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="55">
                                                    <div @click="view(row)" class="pt-1">
                                                        <p v-if="row.messageable_type == 'App\\Models\\Service'" class="fw-bold mb-0 text-purple" style="color: purple;">{{row.category | reduceText(10, '...')}}</p>
                                                        <p v-if="row.messageable_type == 'App\\Models\\Business'" class="fw-bold mb-0 text-grey" style="color: orange;">{{row.category | reduceText(10, '...')}}</p>
                                                        <p v-if="row.messageable_type == 'App\\Models\\Professional'" class="fw-bold mb-0 text-blue" style="color: blue;">{{row.category | reduceText(10, '...')}}</p>
                                                        <p v-if="row.messageable_type == 'App\\Models\\Job'" class="fw-bold mb-0 text-pink" style="color: pink;">{{row.category | reduceText(10, '...')}}</p>
                                                        <p v-if="row.messageable_type == 'App\\Models\\Event'" class="fw-bold mb-0 text-yellow" style="color: yellow;">{{row.category | reduceText(10, '...')}}</p>
                                                        <p v-if="row.messageable_type == 'App\\Models\\User'" class="fw-bold mb-0 text-red" style="color: red;">{{row.category | reduceText(10, '...')}}</p>
                                                        <div v-if="row.replies.legth != 0">
                                                            <p v-if="row.replies[0]"  class="small text-white">{{row.replies[0].msg|reduceText(10, '...')}}</p>
                                                            <p v-else  class="small text-white">{{row.msg| reduceText(10, '...')}}</p>
                                                        </div>
                                                        <div v-else>
                                                            <p v-if="row.msg" class="fw-bold mb-0 text-green" style="color: green;">{{row.msg| reduceText(10, '...')}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="pt-1">
                                                    <div v-if="row.replies.legth != 0">
                                                        <p v-if="row.replies[0]" class="small text-white mb-1">{{row.replies[0].created_at|lastTime}}</p>
                                                        <p v-else class="small text-white mb-1">{{row.created_at|lastTime}}</p>
                                                    </div>
                                                    <p v-else class="small text-white mb-1">{{row.created_at|lastTime}}</p>
                                                    <div class="float-end">
                                                        <span @click.prevent="removeMessage(row)" class="badge bg-danger"><i class="fa fa-trash"></i></span>
                                                        <span @click.prevent="blackList(row.id, 'message')" class="badge bg-success"><i class="fa fa-trash"></i></span>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </li>

                                    <li v-if="showT && getChatData.to">
                                        <div v-for="(row, index) in getChatData.to" :key="index" class="p-2 border-bottom" style="border-bottom: 1px solid rgba(255,255,255,.3) !important;">
                                            <div class="d-flex justify-content-between link-light">
                                                <div class="d-flex flex-row">
                                                    <img :src="row.user.pic? row.user.pic:'assets/img/d.jpg'" alt="avatar"
                                                    class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="55">
                                                    <div @click="view(row)" class="pt-1">
                                                        <p class="fw-bold mb-0 text-green" style="color: green;">{{row.user.findme_id | reduceText(10, '...')}}</p>
                                                        <div v-if="row.replies.legth != 0">
                                                            <p v-if="row.replies[0]"  class="small text-white">{{row.replies[0].msg|reduceText(10, '...')}}</p>
                                                            <p v-else  class="small text-white">{{row.msg| reduceText(10, '...')}}</p>
                                                        </div>
                                                        <div v-else>
                                                            <p v-if="row.msg" class="fw-bold mb-0 text-green" style="color: green;">{{row.msg| reduceText(10, '...')}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="pt-1">
                                                    <div v-if="row.replies.legth != 0">
                                                        <p v-if="row.replies[0]" class="small text-white mb-1">{{row.replies[0].created_at|lastTime}}</p>
                                                        <p v-else class="small text-white mb-1">{{row.created_at|lastTime}}</p>
                                                    </div>
                                                    <p v-else class="small text-white mb-1">{{row.created_at|lastTime}}</p>
                                                    <div class="float-end">
                                                        <span @click.prevent="removeMessage(row)" class="badge bg-danger"><i class="fa fa-trash"></i></span>
                                                        <span @click.prevent="blackList(row.id, 'message')" class="badge bg-success"><i class="fa fa-trash"></i></span>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </li>
                                    
                                </ul>

                            </div>
                        </div>

                    </div>

                    <div class="col-md-6 col-lg-7 col-xl-7">
                        <ul v-if="showAds" id="myDivs2" class="list-unstyled text-white" style="height: 525px; overflow-y: auto;">

                            <li class="d-flex justify-content-center mb-4">



                                



                                <div class="" style="margin-top: 29px;border-radius: 0;">


                                    <!-- Carousel -->
                                    <div id="demo" class="carousel slide" data-bs-ride="carousel">

                                        <!-- The slideshow/carousel -->
                                        <div class="carousel-inner">

                                            <div v-for="(item,index) in getAllEvents" :key="index" :class="classText(index)" data-bs-interval="2000">
                                                <div class="view px-4">

                                                    <div class="w-100 h-100 hover-animate" data-marker-id="59c0c8e33b1527bfe2abaf92">
                                                        <div class="card h-100 border-0 shadow">

                                                        <div class="card-img-top overflow-hidden gradient-overlay"> 
                                                            <img class="img-fluid w-100" :src="item.image" alt="Modern, Well-Appointed Room"/>
                                                            <!-- <router-link class="tile-link" :to="{path:'/event_1',query:{id: item.id}}" ></router-link> -->
                                                            <div class="card-img-overlay-bottom z-index-20">
                                                                <div class="d-flex text-white text-sm align-items-center">
                                                                    <img class="avatar avatar-border-white flex-shrink-0 me-2" :src="item.image" :alt="item.event_name"/>
                                                                    <div>{{item.event_name}}</div>
                                                                </div>
                                                            </div>
                                                            <div class="card-img-overlay-top text-end">
                                                                <router-link class="card-fav-icon position-relative z-index-40" :to="{path:'/event_1',query:{id: item.id}}" >
                                                                    <svg class="svg-icon text-white">
                                                                    <use xlink:href="#heart-1"> </use>
                                                                    </svg>
                                                                </router-link>
                                                            </div>
                                                        </div>

                                                        <div class="card-body d-flex align-items-center">
                                                            <div class="w-100">
                                                            <h6 class="card-title">
                                                                <router-link class="text-decoration-none text-dark" :to="{path:'/event_1',query:{id: item.id}}" >{{item.event_description}}</router-link>
                                                            </h6>
                                                            <div class="d-flex card-subtitle mb-3">
                                                                <p class="flex-grow-1 mb-0 text-muted text-sm">{{item.address}}</p>
                                                                <p class="flex-shrink-1 mb-0 card-stars text-xs text-end"><i class="fa fa-star text-warning"></i><i class="fa fa-star text-warning"></i><i class="fa fa-star text-warning"></i><i class="fa fa-star text-warning"></i><i class="fa fa-star text-warning"></i>
                                                                </p>
                                                            </div>
                                                            <p class="card-text text-muted"><span class="h4 text-primary">{{item.slots}}</span> Slots</p>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>

                                        <!-- Left and right controls/icons -->
                                        <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon"></span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                                            <span class="carousel-control-next-icon"></span>
                                        </button>
                                    </div>



                                </div>

                            </li>
                        </ul>

                        <ul v-else id="myDivs2" class="list-unstyled text-white" style="height: 525px; overflow-y: auto;">

                            <li v-for="(row, index) in filterMessages(pageData.replies)" :key="index" class="d-flex justify-content-between mb-4">
                                
                                <img v-if="row.user_id != user_id" :src="row.user.pic? row.user.pic :'assets/img/d.jpg'" alt="avatar"
                                    class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">

                                <div v-if="row.user_id != user_id" class="card mask-custom">
                                    <div class="card-header d-flex justify-content-between p-3"
                                        style="border-bottom: 1px solid rgba(255,255,255,.3);">

                                        <p class="fw-bold mb-0 text-green" style="color: yellow;">{{row.user.findme_id}}
                                            <a class="dropdown">
                                                <span style="color: green;" class="span" data-toggle="dropdown" data-bs-toggle="dropdown">
                                                    <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                                </span>
                                                <div class="dropdown-menu">
                                                    <div class="dropdown-item">
                                                        <span title="React" @click.prevent="react(row)" class="badge bg-success"><i class="fa fa-reply"></i></span>
                                                        <!-- <span title="Delete for all" @click.prevent="removeReply(row)" class="badge bg-danger"><i class="fa fa-trash"></i></span> -->
                                                        <span title="Delete for me" @click.prevent="blackList(row.id, 'reply')" class="badge bg-success"><i class="fa fa-times"></i></span>
                                                    </div>
                                                    <!-- <a  @click.prevent="react(row)" class="dropdown-item"  title="Make Admin" href="#">
                                                        <i class="fa fa-pencil text-green" style="color: green;"></i> React
                                                    </a>
                                                    <a  @click.prevent="blackList(row.id, 'reply')" class="dropdown-item"  title="Remove" href="#">
                                                        <i class="fa fa-trash text-red" style="color: green;"></i> Remove for me
                                                    </a> -->
                                                </div>
                                            </a>
                                        </p>

                                        <p class="text-light small mb-0"><i class="far fa-clock"></i> {{row.created_at|lastTime}}</p>
                                        
                                    </div>

                                    <div v-if="row.parent" class="card-header d-flex justify-content-between p-3"
                                        style="border-bottom: 1px solid rgba(255,255,255,.3);">

                                        <div class="d-flex align-self-start me-3">
                                            <img :src="row.parent.user.pic? row.parent.user.pic : 'assets/img/d.jpg'" alt="avatar"
                                                class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="40">
                                            <p class="fw-bold mb-0 text-yellow" style="color: yellow;">{{row.parent.user.findme_id}}</p>
                                        </div>    
                                            
                                        <p class="text-light small mb-0"><i class="far fa-clock"></i> {{row.parent.created_at|lastTime}}</p>
                                    </div>

                                    <div class="card-body">
                                        <p class="mb-0">
                                        {{row.msg}}
                                        </p>
                                    </div>
                                </div>





                                <div v-if="row.user_id == user_id" class="card mask-custom w-100">
                                    <div class="card-header d-flex justify-content-between p-3"
                                        style="border-bottom: 1px solid rgba(255,255,255,.3);">
                                        <p class="fw-bold mb-0 text-green" style="color: green;">{{row.user.findme_id}} (You)
                                            <a class="dropdown">
                                                <span style="color: green;" class="span" data-toggle="dropdown" data-bs-toggle="dropdown">
                                                    <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                                </span>
                                                <div class="dropdown-menu">
                                                    <div class="dropdown-item">
                                                        <span title="React" @click.prevent="react(row)" class="badge bg-success"><i class="fa fa-reply"></i></span>
                                                        <span title="Delete for all" @click.prevent="removeReply(row)" class="badge bg-danger"><i class="fa fa-trash"></i></span>
                                                        <span title="Delete for me" @click.prevent="blackList(row.id, 'reply')" class="badge bg-success"><i class="fa fa-times"></i></span>
                                                    </div>
                                                    <!-- <a  @click.prevent="react(row)" class="dropdown-item"  title="Make Admin" href="#">
                                                        <i class="fa fa-pencil text-green" style="color: green;"></i> React
                                                    </a>
                                                    <a  @click.prevent="removeReply(row)" class="dropdown-item"  title="Remove" href="#">
                                                        <i class="fa fa-trash text-red" style="color: red;"></i> Delete
                                                    </a>
                                                    <a  @click.prevent="blackList(row.id, 'reply')" class="dropdown-item"  title="Remove" href="#">
                                                        <i class="fa fa-trash text-red" style="color: green;"></i> Remove for me
                                                    </a> -->
                                                </div>
                                            </a>
                                        </p>

                                        <p class="text-light small mb-0"><i class="far fa-clock"></i> {{row.created_at|lastTime}}</p>
                                    </div>

                                    <div v-if="row.parent" class="card-header d-flex justify-content-between p-3"
                                        style="border-bottom: 1px solid rgba(255,255,255,.3);">

                                        <div class="d-flex align-self-start me-3">
                                            <img :src="row.parent.user.pic? row.parent.user.pic :'assets/img/d.jpg'" alt="avatar"
                                                class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="40">
                                            <p class="fw-bold mb-0 text-yellow" style="color: yellow;">{{row.parent.user.findme_id}}</p>
                                        </div>    
                                            
                                        <p class="text-light small mb-0"><i class="far fa-clock"></i> {{row.parent.created_at|lastTime}}</p>
                                    </div>

                                    <div class="card-body">
                                        <p class="mb-0">
                                        {{row.msg}}
                                        </p>
                                    </div>
                                </div>
                                <img v-if="row.user_id == user_id" :src="row.user.pic? row.user.pic: 'assets/img/d.jpg'" alt="avatar"
                                class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60">
                                
                            </li>
                            
                            
                        </ul>

                        <div v-if="reactMessage != null" class="row mt-2" style="background:linear-gradient(0deg, rgba(121, 49, 49, 0.493), rgba(223, 89, 28, 0.3)); border-top-right-radius: 25px; border-top-left-radius: 25px; ">
                            <div class="d-flex justify-content-between link-light">

                                <div class="d-flex flex-row">
                                    <img :src="reactMessage.user.pic? reactMessage.user.pic : 'assets/img/d.jpg'" alt="avatar"
                                    class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="30">
                                    <div class="pt-1">
                                        <p class="fw-bold mb-0">{{reactMessage.user.findme_id}}</p>
                                        <p class="small text-white">{{reactMessage.msg|reduceText(10, '...')}}</p>
                                    </div>
                                </div>
                                <div class="pt-1">
                                    <p class="small text-white mb-1">{{reactMessage.created_at|lastTime}}</p>
                                    <span @click.prevent="cancelReply()" class="badge bg-danger"><i class="fa fa-times"></i></span>
                                </div>
                                
                            </div>
                        </div>
                        
                        <div style="background:linear-gradient(0deg, rgba(121, 49, 49, 0.493), rgba(223, 89, 28, 0.3)); border-bottom-right-radius: 25px; border-bottom-left-radius: 25px;" class="text-muted row justify-content-start align-items-center pe-3 pt-1 mb-3">

                            <div class="col-1 mx-1">
                                <img :src="user_pic?user_pic : 'assets/img/d.jpg'" alt="avatar"
                                class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="40">
                            </div>
                            
                            <div class="col-8">
                                
                                <div class="row mx-1">
                                    <div class="d-flex">
                                        <div class="col-12">
                                            <textarea v-model="formData.msg" class="form-control" rows="1"></textarea>
                                        </div>
                                        <div class="col-6">
                                            <a class="ms-3 text-muted" href="#!"><i class="fas fa-paperclip"></i></a>
                                            <a class="ms-3 text-muted" href="#!"><i class="fas fa-smile"></i></a>
                                            <a class="ms-3" @click.prevent="sendMessage()" href="#!"><i class="fas fa-paper-plane"></i></a>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                            
                        </div>

                    </div>

                </div>

            </div>
        </section>
        <!-- end -->
        <add-user-moadal ref="adduser" />
        <group-modal ref="group" />
        <view-group-modal ref="viewGroup" />

        
    </div>
</template>
<script>
import Modal from "../components/CustomModal.vue";
import helper from '../helpers/helpers';
import { createNamespacedHelpers } from 'vuex';
import CustomInput from '../components/CustomInput.vue';
const { mapActions, mapGetters } = createNamespacedHelpers('single');
const { mapGetters: mapGettersForAds, mapActions: mapActionsForAds } = createNamespacedHelpers('inventory');

import AddUserMoadal from './AddUserModal';
import GroupModal from './GroupModal';
import ViewGroupModal from './ViewGroupModal';

export default {
    components: {
        Modal,
        CustomInput,
        AddUserMoadal,
        GroupModal,
        ViewGroupModal
    },
    data() {
        return {
            saveLoading:false,
            user_id: 0,
            user_pic: '',
            showG: 1,
            showF: 1,
            showT: 1,
            value: '',
            showAds: false,

            blackLists: null,

            pageData:{
                id: 0,
                message: "",
                replies: []
            },

            reactMessage: null,

            formData: {
                id: 0,
                message_id: 0,
                reply_id: 0,
                type: '',
                msg: "",
                attached: [],

            },
            
        }
    },
    methods: {
        ...mapActions(['allChatHistoryAction', 'saveReplyAction', 'deleteReplyAction', 'deleteMessageAction', 'deleteReplyAction', 'deleteGroupForMeAction', 'deleteGroupUserAction', 'deleteGroupAction', 'makeGroupAdminAction', 'getLastPageAction', 'setLastPageAction', 'setMyRemovedMessageAction', 'getMyRemovedMessageAction']),

        ...mapActionsForAds(['allBusinessAction', 'allServiceAction', 'allJobAction', 'allProfessionalAction', 'allEventAction']),

        setLastPage() {
            this.setLastPageAction(this.pageData.id).then((res) => {
                // this.isLoading = false;
            }).catch((error) => {
                // this.isLoading = false;
                helper.errorMessage(error);
            });
        },

        checkAdmin(row) {
            let check = false
            row.filter((value) => {
                
                if(value.user_id == this.user_id && value.status == 1) {
                    check = true;
                }
            });

            return check
            
        },

        filterMessages(row){
            // var arr = obj1.filter(function(item){
            //     return obj2.indexOf(item.id) === -1;
            // });

            // const arr = obj1.filter(i => !obj2.includes(i.id))
            if(this.blackLists != null) {
                let arr = row.filter(value => !this.blackLists.includes(value.id));
                return arr;
            } else {
                return row;
            }
            
        },

        blackList(id, type) {
            let data = {id: id, type: type};
            helper.deletingAlert("this message will be deleted for you alone")
            .then((result) => {
                if (result.value) {
                    this.isLoading = true;
                    this.setMyRemovedMessageAction(data)
                    .then((res) => {
                        this.getMyRemovedMessageAction()
                        this.allChatHistoryAction()
                        this.isLoading = false;
                        helper.successAlert("message deleted");
                    }).catch((error) => {
                        this.isLoading = false;
                        helper.errorMessage(error);
                    });
                }
            });
        },

        getLastPage() {
            this.setLastPage(); // to be taken

            this.getLastPageAction().then((res) => {
                this.pageData = res

                if(res.length == 0) {
                    this.showAds = true;
                } else {
                    this.showAds = false;
                }
                // this.isLoading = false;
            }).catch((error) => {
                // this.isLoading = false;
                // helper.errorMessage(error);
                this.showAds = true;
            });
        },

        changeHeight() {
            document.getElementById("myDivs1").style.height = "530px";
            document.getElementById("myDivs2").style.height = "440px";
        },
        resetHeight() {
            document.getElementById("myDivs1").style.height = "550px";
            document.getElementById("myDivs2").style.height = "525px";
        },

        
        showAddModal(row) {
            this.$refs.adduser.openAddModal(row);
        },

        shareGroup(row, type) {

            // window.location.host : you'll get sub.domain.com:8080 or sub.domain.com:80
            // window.location.hostname : you'll get sub.domain.com
            // window.location.protocol : you'll get http:
            // window.location.port : you'll get 8080 or 80
            // window.location.pathname : you'll get /virtualPath
            // window.location.origin : you'll get http://sub.domain.com *****

            // var root = location.protocol + '//' + location.host;

            // let url = window.location.href;
            let url = window.location.hostname+'/join-group?id='+row.id;
            let title = row.name+' EGAL Page';
            let message = "Hi here is an invitation to EGAL ghana "+row.name+" which is about "+row.description;

            // http://www.reddit.com/submit?url=<EncodedURL>
            // mailto:?subject=[SUBJECT]&body=<URL>"
            // http://pinterest.com/pin/create/button/?url=[EncodedURL]&media=[MEDIA]
            // https://plus.google.com/share?url=<URL>
            // https://www.linkedin.com/shareArticle?mini=true&url=<URL>&t=<TITLE>

            // let whatsapp = `https://wa.me/text=${url}. ${message}`;
            let whatsapp = `whatsapp://send?text=${url}. ${message}`;
            let telegram = `https://t.me/share/url?url=${url}&text=${message}`;
            let twitter = `https://twitter.com/intent/tweet?text=${url}. ${message}`;
            let facebook = `https://www.facebook.com/sharer/sharer.php?u=${url}&t=${message}`
            // https://www.facebook.com/sharer/sharer.php?u=<URL>&t=<TITLE>

            let email = `mailto:?subject=${url} ${message}&body=${title}`
            let linkedin = `https://www.linkedin.com/shareArticle?mini=true&url=${url}&t=${title}`

            if(type == 'whatsapp') {
                window.open(whatsapp, 'blank')
            } else if(type == 'facebook') {
                window.open(facebook, 'blank')
            } else if(type == 'telegram') {
                window.open(telegram, 'blank')
            } else if(type == 'twitter') {
                window.open(twitter, 'blank')
            } else if(type == 'linkedin') {
                window.open(linkedin, 'blank')
            } else if(type == 'email') {
                window.open(email, 'blank')
            }

            // alert('hello there')
        },

        removeGroupForMe(row) {
            helper.deletingAlert("this greoup will be deleted for you")
            .then((result) => {
                if (result.value) {
                    this.isLoading = true;
                    this.deleteGroupForMeAction(row)
                    .then((res) => {
                        this.isLoading = false;
                        helper.successAlert("group deleted");
                    }).catch((error) => {
                        this.isLoading = false;
                        helper.errorMessage(error);
                    });
                }
            });
        },

        react(row) {
            this.formData.reply_id = row.id;
            this.reactMessage = row;
            this.changeHeight();
        },

        cancelReply() {
            this.formData.reply_id = 0;
            this.reactMessage = null;
            this.resetHeight()
        },

        removeReply(row) {
            helper.deletingAlert("message will be deleted")
            .then((result) => {
                if (result.value) {
                    this.isLoading = true;
                    this.deleteReplyAction(row)
                    .then((res) => {
                        this.isLoading = false;
                        helper.successAlert("message deleted");
                    }).catch((error) => {
                        this.isLoading = false;
                        helper.errorMessage(error);
                    });
                }
            });
        },

        viewGroup(row) {
            this.$refs.viewGroup.openModal(row);
        },

        editGroupModal(row) {
            this.$refs.group.openEditModal(row);
        },
        addModal() {
            this.$refs.group.openAddModal();
        },

        clearData(){
            // this.formData.message_id = 0;
            this.formData.reply_id = 0;
            this.formData.msg = "";
            this.formData.type = "";
            this.formData.attached = [];
        },

        clearAllFormData(){
            this.formData.message_id = 0;
            this.formData.reply_id = 0;
            this.formData.msg = "";
            this.formData.type = "";
            this.formData.attached = [];
        },

        uploadFiles(file){

            if(file.length > 0) {
                file.forEach(element => {
                    const files = helper.uploadAnyFileUsingComponent(element);
                    const fPreview = helper.previewImageComponent(files);
                    this.files.push(fPreview);
                    this.formData.files.push(files);
                });
            } else {
                this.formData.files = [];
                this.files = [];
            }
        },

        view(row){
            this.pageData = row;
            this.formData.message_id = row.id;
            this.showAds = false;
        },

        removeUser(row) {
            helper.deletingAlert("user will be deleted")
            .then((result) => {
                if (result.value) {
                    this.isLoading = true;
                    this.deleteGroupUserAction(row)
                    .then((res) => {
                        this.isLoading = false;
                        helper.successAlert("user deleted");
                    }).catch((error) => {
                        this.isLoading = false;
                        helper.errorMessage(error);
                    });
                }
            });
        },

        removeMessage(row) {
            helper.deletingAlert("message will be deleted")
            .then((result) => {
                if (result.value) {
                    this.isLoading = true;
                    this.deleteMessageAction(row)
                    .then((res) => {
                        this.isLoading = false;
                        helper.successAlert("message deleted");
                    }).catch((error) => {
                        this.isLoading = false;
                        helper.errorMessage(error);
                    });
                }
            });
        },

        removeGroup(row) {
            helper.deletingAlert("this greoup will be deleted")
            .then((result) => {
                if (result.value) {
                    this.isLoading = true;
                    this.deleteGroupAction(row)
                    .then((res) => {
                        this.isLoading = false;
                        helper.successAlert("group deleted");
                    }).catch((error) => {
                        this.isLoading = false;
                        helper.errorMessage(error);
                    });
                }
            });
        },

        makeAdmin(row) {
            helper.deletingAlert("user will now have admin rights")
            .then((result) => {
                if (result.value) {
                    this.isLoading = true;
                    this.makeGroupAdminAction(row)
                    .then((res) => {
                        this.isLoading = false;
                        helper.successAlert("Done successfully");
                    }).catch((error) => {
                        this.isLoading = false;
                        helper.errorMessage(error);
                    });
                }
            });
        },

        sendMessage(){
            // console.log(this.formData.msg);
            if(this.formData.msg != '' && this.formData.message_id != 0) {
                this.isLoading = true;
                this.saveReplyAction(this.formData).then(() => {

                    this.refreshData();

                    this.isLoading = false;
                }).catch((error) => {
                    this.isLoading = false;
                    // helpers.errorToastAlert(error);
                });
            } else {
                helper.errorAlert("No message to be sent");
            }
            
        },
        refreshData() {
            this.cancelReply();
            this.getLastPage();
            this.getMyRemovedMessageAction()
            this.allChatHistoryAction();
            this.clearData();
        },
        myListener() {
            Echo.channel('chat')
                .listen('NewChatMessage', (e) => {
                    console.log('wow!')
                    // this.comments.unshift(res.comment)  //just nothing
                    // if(e.user != this.userId) {
                    //     this.messages.push({
                    //         text: e.message,
                    //         user: e.user
                    //     });
                    // }
                });
            // Echo.channel('chat'.this.formData.message_id)
            //     .listen('NewChatMessage', (e) => {
            //         console.log('wow!')
            //         // this.comments.unshift(res.comment)  //just nothing
            //         // if(e.user != this.userId) {
            //         //     this.messages.push({
            //         //         text: e.message,
            //         //         user: e.user
            //         //     });
            //         // }
            //     });

            // Echo.private('chat'.this.formData.message_id)
            //     .listen('NewChatMessage', (e) => {
            //         console.log('wow!')
            //         // this.comments.unshift(res.comment)  //just nothing
            //         // if(e.user != this.userId) {
            //         //     this.messages.push({
            //         //         text: e.message,
            //         //         user: e.user
            //         //     });
            //         // }
            //     });
        },

        filter(num){
            if( num == 1) {
                this.showG = 1;
                this.showF = 0;
                this.showT = 0;
            } else if( num == 2) {
                this.showG = 0;
                this.showF = 1;
                this.showT = 0;
            } else if( num == 2) {
                this.showG = 0;
                this.showF = 0;
                this.showT = 1;
            } else if( num == 0) {
                this.showG = 1;
                this.showF = 1;
                this.showT = 1;
            }
            
        },

        classText(index) {
            let text = 'carousel-item active';
            if(index == 0) {
                return 'carousel-item active';
            } else {
                return 'carousel-item';
            }
        },

        getAllBlackListed() {

            this.getMyRemovedMessageAction().then((res) => {
                this.blackLists = this.getDeletedForMe;
            }).catch((error) => {
                // helper.errorMessage(error);
                this.blackLists = false;
            });
        },


    },
    created() {
        this.user_id = JSON.parse(localStorage.getItem('findMe')).auth.user.id;
        this.user_pic = JSON.parse(localStorage.getItem('findMe')).auth.user.pic;
        this.getAllBlackListed();
        this.allChatHistoryAction()
        this.getLastPage();
        this.allEventAction();
    },
    computed: {
        ...mapGetters(['getChatHistory', 'getDeletedForMe']),

        ...mapGettersForAds(['getAllBusinesses', 'getAllServices', 'getAllJobs', 'getAllEvents', 'getAllProfessionals']),

        getChatData() {

            this.blackLists = this.getDeletedForMe;

            if(this.value != ''){
                let group = helper.filterData(this.getChatHistory.group, this.value)
                let from = helper.filterData(this.getChatHistory.from, this.value)
                let to = helper.filterData(this.getChatHistory.to, this.value)
                let arr = {
                    'group': group,
                    'from': from,
                    'to': to
                };
                return arr;
            }else{
                return this.getChatHistory;
            }
        },
    },

    mounted() {
        Echo.channel('chat')
            .listen('NewChatMessage', (e) => {
                // console.log('wow!')
                this.refreshData();
            });
    },

    
}
</script>
<style scoped>

    /* chat */
        .gradient-custom {
            /* fallback for old browsers */
            background: #fccb90;
            

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to bottom right, rgb(207, 94, 50), rgb(250, 97, 58));

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to bottom right, rgb(211, 110, 51), rgb(248, 75, 53))
        }

    .mask-custom {
        background: rgba(24, 24, 16, .2);
        border-radius: 2em;
        backdrop-filter: blur(15px);
        border: 2px solid rgba(255, 255, 255, 0.05);
        background-clip: padding-box;
        box-shadow: 10px 10px 10px rgba(46, 54, 68, 0.03);
    }

    /* end */


    .nothing {
        /* primary */
        border: 2px solid rgb(49, 163, 26);

        /* yello */
        border: 2px solid rgb(223, 187, 27);

        /* blue */
        border: 2px solid rgb(35, 62, 212);

        /* red */
        border: 2px solid rgb(228, 37, 37);

        /* primary */
        border: 2px solid rgb(41, 190, 86);

        /* primary */
        border: 2px solid rgb(49, 163, 26);
    }
</style>