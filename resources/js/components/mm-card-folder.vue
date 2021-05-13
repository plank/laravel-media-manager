<template>
  <div data-type="folder" class="mm__card">
    <div class="mm__card-infos">
      <svg width="20" height="16" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill-rule="nonzero"><path d="M18.684 15.168H1.053A1.053 1.053 0 010 14.116V1.069C0 .488.471.017 1.053.017H6.03c.38 0 .73.205.917.536l.58 1.032c.187.332.538.537.918.537h10.239c.581 0 1.053.471 1.053 1.052v10.942c0 .581-.472 1.052-1.053 1.052z" fill="#AAA"/><path d="M1.053 15.505h17.631c.581 0 1.053-.47 1.053-1.052V3.512c0-.582-.472-1.053-1.053-1.053h-7.609c-.38 0-.73.205-.917.537l-.58 1.032a1.053 1.053 0 01-.918.536H1.053C.47 4.564 0 5.035 0 5.617v8.836c0 .581.471 1.052 1.053 1.052z" fill="gray"/></g></g></svg>
      <h6>{{ item.name | clearname }}</h6>
      <span class="date"
        >{{ $t("actions.created_on") }}
        {{ item.timestamp | moment("MMMM Do, YYYY") }}</span
      >
    </div>
  </div>
</template>

<script>
export default {
  name: "mmfoldercard",
  props: ["item"],
  filters: {
    clearname: function (name) {
      name = name.split("/");
      return name[name.length - 1];
    },
  },
};
</script>
