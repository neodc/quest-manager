<template>
	<div class="play-step" :class="'state-' + step.state">
		<h4>
			<input v-if="editing" v-model="editedStep.name" class="is-inline">
			<template v-else>{{ step.name }}</template>
			<span class="play-actions">
				<a
					v-if="step.state === 'todo' || showSelectState"
					title="todo"
					@click="selectState('todo')"
					:class="{'option-availible': step.state !== 'todo'}"
				>
					<i>📋</i>
				</a>
				<a
					v-if="step.state === 'in_progress' || showSelectState"
					title="in progress"
					@click="selectState('in_progress')"
					:class="{'option-availible': step.state !== 'in_progress'}"
				>
					<i>⏳</i>
				</a>
				<a
					v-if="step.state === 'done' || showSelectState"
					title="done"
					@click="selectState('done')"
					:class="{'option-availible': step.state !== 'done'}"
				>
					<i>🏅</i>
				</a>

				<template v-if="user.isDM">
					<a v-if="step.is_visible" title="hide" @click="toggleVisibility"><i>🚹</i></a>
					<a v-else title="show" @click="toggleVisibility"><i>🚷</i></a>
				</template>

				<a title="comment" @click="$emit('step-comment', step)"><i>💬</i></a>
			</span>
			<span v-if="user.isDM" class="play-actions play-actions-dm">
				<a v-if="!isFirst" title="up" @click="move(-1)"><i>👆</i></a>
				<a v-if="!isLast" title="down" @click="move(1)"><i>👇</i></a>

				<a v-if="editing" title="validate" @click="validateEdit"><i>✅️</i></a>
				<a v-else title="edit" @click="edit"><i>✏️</i></a>

				<a v-if="editing" title="cancel" @click="cancelEdit"><i>❌</i></a>
				<a v-else title="delete" @click="remove"><i class="no-color">🗑️</i></a>
			</span>
		</h4>
		<textarea v-if="editing" v-model="editedStep.player_content" class="is-fullwidth"></textarea>
		<div v-else class="player-content" v-html="step.player_content_html"></div>
		<div v-if="(step.dm_content || editing) && user.isDM" class="dm-content">
			<hr>
			<textarea v-if="editing" v-model="editedStep.dm_content" class="is-fullwidth"></textarea>
			<div v-else v-html="step.dm_content_html"></div>
		</div>
	</div>
</template>

<script>
    export default {
        props: {
			step: {
				type: Object,
				required: true,
			},
			user: {
				type: Object,
				required: true,
			},
			isFirst: {
				type: Boolean,
				required: true,
			},
			isLast: {
				type: Boolean,
				required: true,
			},
        },
		data() {
        	return {
        		showSelectState: false,
				editing: false,
				editedStep: null,
			};
		},
		methods: {
			selectState(state) {
				if(!this.user.isDM) {
					return;
				}

				if( !this.showSelectState ) {
					this.showSelectState = true;
					return;
				}

				this.showSelectState = false;

				if( state !== this.step.state ) {
					this.$emit('state-change', {id: this.step.id, state: state});
				}
			},
			toggleVisibility() {
				if(!this.user.isDM) {
					return;
				}

				this.$emit('visibility-change', {id: this.step.id, is_visible: !this.step.is_visible});
			},
			edit() {
				this.editedStep = _.cloneDeep(this.step);
				this.editing = true;
			},
			validateEdit() {
				this.$emit('edited', this.editedStep);
				this.editing = false;
			},
			cancelEdit() {
				this.editing = false;
			},
			remove() {
				if(confirm('Are you sure you want to delete the step "' + this.step.name + '"?')) {
					this.$emit('delete', {id: this.step.id})
				}
			},
			move(orderChange) {
				this.$emit('move', orderChange);
			},
		},
	}
</script>
