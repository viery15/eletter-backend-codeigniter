<template id="input-component">
  <v-dialog v-model="dialog" persistent max-width="800px">
        <template v-slot:activator="{ on }">
          <v-btn fab dark color="indigo" v-on="on">
            <v-tooltip bottom>
              <template v-slot:activator="{ on }">
                <v-icon >add</v-icon>
              </template>
              <span>{{tooltip}}</span>
            </v-tooltip>
          </v-btn>
        </template>
        <v-card>
          <v-card-title>
            <span class="headline">New Component</span>
          </v-card-title>
          <v-card-text>
            <v-container grid-list-md>
              <v-layout row>
                <v-flex xs12 md6>
                  <v-text-field label="Name*" v-model="name" required></v-text-field>
                </v-flex>
                <v-flex xs12 md6>
                  <v-text-field label="Variable Name*" v-model="variable_name" required></v-text-field>
                </v-flex>
                <v-flex xs12 md6>
                  <v-select
                    :items="['text','textarea','number','radio','checkbox','date']"
                    label="Type*"
                    required
                    v-model="type"
                  ></v-select>
                </v-flex>
              </v-layout>
            </v-container>
            <small>*indicates required field {{type}} {{name}} {{variable_name}}</small>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" flat @click="dialog = false">Save</v-btn>
            <v-btn color="blue darken-1" flat @click="dialog = false">Close</v-btn>

          </v-card-actions>
        </v-card>
      </v-dialog>
</template>


<template id="data-table">
  <v-card>
      <v-card-title>
        Components
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="search"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
      </v-card-title>
      <v-data-table
        :headers="headers"
        :items="components"
        :search="search"
      >
        <template v-slot:items="props">
          <td>{{ props.item.name }}</td>
          <td class="text-xs-justify">{{ props.item.variable_name }}</td>
          <td class="text-xs-justify">{{ props.item.html_basic }}</td>
          <td class="text-xs-center">
            <v-btn fab dark small color="#FFD600">
              <v-icon dark>create</v-icon>
            </v-btn>
            <v-btn fab dark small color="red">
              <v-icon dark>delete</v-icon>
            </v-btn>
          </td>
        </template>
        <v-alert v-slot:no-results :value="true" color="error" icon="warning">
          Your search for "{{ search }}" found no results.
        </v-alert>
      </v-data-table>
    </v-card>
</template>
