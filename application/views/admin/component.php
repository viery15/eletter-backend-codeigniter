<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <!-- <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet"> -->
    <link  rel="stylesheet" href="<?= base_url() ?>css/bootstrap.min.css"/>
    <link  rel="stylesheet" href="<?= base_url() ?>font-awesome/css/font-awesome.min.css"/>
    <!-- <link href="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.min.css" rel="stylesheet"> -->
    <script type="text/javascript" src="<?= base_url() ?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.8/dist/vue.js"></script>
    <script src="https://unpkg.com/vuex@3.1.0/dist/vuex.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="https://cdn.jsdelivr.net/npm/vee-validate@latest/dist/vee-validate.js"></script>

    <title>e-Letter</title>
  </head>
  <body>
    <!--Navbar-->
    <?php $this->load->view('admin/partials/navbar.php') ?>
    <!--/.Navbar-->
    <div id="app">
      <div class="container" style="max-width:93%">
        <div class="row">
          <div class="col-md-12">
            <br /><br />
            <button v-on:click="newComponent()" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-form">Create New Component</button><br /><br />
            <table class="table table-striped table-bordered">
              <tr>
                <th style="text-align:center" v-for='column in columns'>{{column}}</th>
                <th style="text-align:center">Action</th>
              </tr>
              <tr v-if="component.length !== 0" v-for='component in components'>
                <td width='20%'>{{component.name}}</td>
                <td width='20%'>{{component.variable_name}}</td>
                <td>{{component.html_basic}}</td>
                <td style="text-align:center" width='15%'>
                  <button v-on:click="editComponent(component.id)" class="btn btn-md btn-warning" data-toggle="modal" data-target="#modal-form"><i class="fa fa-pencil"> </i></button>
                  <button v-on:click="destroy(component.id)" class="btn btn-md btn-danger"><i class="fa fa-trash"> </i></button>
                  <button v-on:click="view(component.id)" class="btn btn-md btn-info " data-toggle="modal" data-target="#modal-view"><i class="fa fa-eye"> </i></button>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div id="modal-form" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg" style="max-width:900px">
          <!-- Modal content-->
          <div class="modal-content ">
            <div class="modal-header">
              <h5 class="modal-title">{{modal_header}}</h5>
              <button type="button" class="pull-right close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <h6>Basic Setting</h6><hr />
                  <form id='input-component'>
                  <div class="form-group">
                    <label for="usr">Name: * </label><br />
                    <input name="name" v-validate="'required'" autocomplete="off" v-model="inputComponent.name" type="text" class="form-control">
                    <span style="color:red">{{ errors.first('name') }}</span>
                  </div>
                  <div class="form-group">
                    <label for="usr">Variable Name: * </label>
                    <input v-validate="'required'" name="variable_name" autocomplete="off" v-model="inputComponent.variable_name" type="text" class="form-control">
                    <span style="color:red">{{ errors.first('variable_name') }}</span>
                  </div>
                  <div class="form-group">
                    <label for="sel1">Input type: * </label>
                    <select name="type" v-validate="'required'" v-on:change="onChange($event)" class="form-control" v-model="inputComponent.type">
                      <option value="" disabled selected>Select input type</option>
                      <option v-for='input in inputType'>{{input}}</option>
                    </select>
                    <span style="color:red">{{ errors.first('type') }}</span>
                  </div>
                  </form>

                </div>
                <div class="col-md-6">
                  <div v-if="inputComponent.type == 'radio' || inputComponent.type == 'checkbox' || inputComponent.type == 'dropdown'">
                    <h6>Option Setting</h6><hr />
                    <div v-for="(option, index) in options">
                      <div class="form-group">
                        <label for="usr">Option {{option.countOption}}: </label>
                        <div class="row">
                          <div class="col-md-11">
                              <input :name="'option'+option.countOption" v-validate="'required'" :placeholder="'option '+ option.countOption" v-model="option.option" style="width:90%" autocomplete="off" type="text" class="form-control">
                              <span style="color:red">{{ errors.first('option'+option.countOption) }}</span>
                          </div>
                          <div class="col-md-1">
                            <button v-on:click="removeOption(index)" v-if="options.length > 1" class="btn btn-danger btn-sm pull-right"><i class="fa fa-close"></i></button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="text-center">
                      <button v-on:click="addOption()" v-if="inputComponent.type == 'radio' || inputComponent.type == 'checkbox' || inputComponent.type == 'dropdown'" class="btn btn-success btn-sm center"><i class="fa fa-plus"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">


                <div class="col-md-12">
                  <h6>Attribut Setting</h6><hr />
                  <div class="row" v-for="(attribut, index) in attributs">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="usr">Attribut {{attribut.count}}: </label>
                        <input :placeholder="'attribut ' + attribut.count" v-model="attribut.attribut" autocomplete="off" type="text" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-5">
                      <div class="form-group">
                        <label for="usr">Value {{attribut.count}} :  </label>
                        <input :placeholder="'value ' + attribut.count" v-model="attribut.value" autocomplete="off" type="text" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-1">
                      <div class="form-group">
                        <br />
                        <button v-on:click="removeAttribut(index)" v-if="attributs.length > 1" class="btn btn-danger btn-sm pull-right"><i class="fa fa-close"></i></button>
                      </div>

                    </div>
                  </div>
                  <div class="text-center">
                    <button v-on:click="addAttribut()" class="btn btn-success btn-sm center"><i class="fa fa-plus"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button v-if="modal_header == 'New Component'" v-on:click="addComponent()" type="button" class="btn btn-save btn-success" >Save</button>
              <button v-if="modal_header == 'Edit Component'" v-on:click="updateComponent(inputComponent.id)" type="button" class="btn btn-save btn-success">Update</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>

      <!-- MODAL VIEW  -->

      <div id="modal-view" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
          <!-- Modal content-->
          <div class="modal-content ">
            <div class="modal-header">
              <h5 class="modal-title" v-html="view_data.name"></h5>
              <button type="button" class="pull-right close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div v-html="view_data.html_basic"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>

    </div>
  </body>
</html>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.js"></script> -->

<!-- type text number  -->
<template id="input-text">
  <form>
    <div class="form-group">
      <label for="readonly">Placeholder: </label>
      <input v-model="placeholder" autocomplete="off" type="text" class="form-control">
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="readonly">Auto Complete: </label><br />
          <div class="form-check-inline">
            <label class="form-check-label">
              <input type="radio" name="autocomplete" v-model="autocomplete" value="on"/>On
            </label>
          </div>
          <div class="form-check-inline">
            <label class="form-check-label">
              <input type="radio" name="autocomplete" v-model="autocomplete" value="off"/>Off
            </label>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="readonly">Readonly: </label><br />
          <div class="form-check-inline">
            <label class="form-check-label">
              <input type="radio" v-model="readonly" value="readonly"/>True
            </label>
          </div>
          <div class="form-check-inline">
            <label class="form-check-label">
              <input type="radio" v-model="readonly" value="false"/>False
            </label>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>

<script src="<?= base_url() ?>frontend/component.js"></script>
