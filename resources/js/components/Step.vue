<template>
	<div class="play-step" :class="'state-' + step.state">
		<h4>
			{{ step.name }}
			<span class="play-step-actions-player">
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
			</span>
			<span v-if="user.isDM" class="play-step-actions-dm">
				<a title="edit" @click="edit"><i>✏️</i></a>
				<a title="delete" @click="remove"><i>❌</i></a>
			</span>
		</h4>
		<div class="player-content" v-html="step.player_content"></div>
		<div v-if="step.dm_content && user.isDM" class="dm-content">
			<hr>
			<div v-html="step.dm_content"></div>
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
        },
		data() {
        	return {
        		showSelectState: false,
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
				// TODO
			},
			toggleVisibility() {
				if(!this.user.isDM) {
					return;
				}
				// TODO
			},
			edit() {
				// TODO
			},
			remove() {
				// TODO
			},
		},
	}
</script>
