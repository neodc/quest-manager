<template>
	<div class="play-resource">
		<h4>
			<input v-if="editing" v-model="editedResource.name" class="is-inline">
			<template v-else>{{ resource.name }}</template>
			<span class="play-actions">
				<template v-if="user.isDM">
					<a v-if="resource.is_visible" title="hide" @click="toggleVisibility"><i>🚹</i></a>
					<a v-else title="show" @click="toggleVisibility"><i>🚷</i></a>
				</template>
			</span>
			<span v-if="user.isDM" class="play-actions play-actions-dm">
				<a v-if="editing" title="validate" @click="validateEdit"><i>✅️</i></a>
				<a v-else title="edit" @click="edit"><i>✏️</i></a>

				<a v-if="editing" title="cancel" @click="cancelEdit"><i>❌</i></a>
				<a v-else title="delete" @click="remove"><i class="no-color">🗑️</i></a>
			</span>
		</h4>

		<p class="form-group" v-if="editing">
			<label for="command_by">Command by:</label>
			<select
				id="command_by"
				class="is-fullwidth"
				:size="players.length"
				multiple
				style="height: auto"
				v-model="editedResource.command_by"
			>
				<option v-for="player in players" :value="player.id" v-text="player.name"></option>
			</select>
		</p>

		<div class="play-resource-description">
			<textarea v-if="editing" v-model="editedResource.player_description" class="is-fullwidth"></textarea>
			<div v-else class="player-content" v-html="resource.player_description_html"></div>
			<div v-if="(resource.dm_description || editing) && user.isDM" class="dm-content">
				<hr>
				<textarea v-if="editing" v-model="editedResource.dm_description" class="is-fullwidth"></textarea>
				<div v-else v-html="resource.dm_description_html"></div>
			</div>
		</div>
	</div>
</template>

<script>
    export default {
        props: {
			resource: {
				type: Object,
				required: true,
			},
			user: {
				type: Object,
				required: true,
			},
			users: {
				type: Array,
				required: true,
			},
        },
		data() {
        	return {
				editing: false,
				editedResource: null,
				test: [],
			};
		},
		computed: {
        	players() {
				return this.users.filter(user => !user.is_dm);
			}
		},
		methods: {
			toggleVisibility() {
				this.$emit('visibility-change', {id: this.resource.id, is_visible: !this.resource.is_visible});
			},
			edit() {
				this.editedResource = _.cloneDeep(this.resource);
				this.editedResource.command_by = this.editedResource.command_by.map((user) => user.id);
				this.editing = true;
			},
			validateEdit() {
				this.$emit('edited', this.editedResource);
				this.editing = false;
			},
			cancelEdit() {
				this.editing = false;
			},
			remove() {
				if(confirm('Are you sure you want to delete the resource "' + this.resource.name + '" ?')) {
					this.$emit('delete', {id: this.resource.id})
				}
			},
		},
	}
</script>
