<template>
  <div class="mm__card">
    <div class="mm__card-infos">
      <svg
        width="36px"
        height="32px"
        viewBox="0 0 36 32"
        version="1.1"
        xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink"
      >
        <defs>
          <filter
            x="-87.5%"
            y="-109.4%"
            width="275.0%"
            height="318.8%"
            filterUnits="objectBoundingBox"
            id="filter-3"
          >
            <feOffset
              dx="0"
              dy="1"
              in="SourceAlpha"
              result="shadowOffsetOuter1"
            ></feOffset>
            <feGaussianBlur
              stdDeviation="4"
              in="shadowOffsetOuter1"
              result="shadowBlurOuter1"
            ></feGaussianBlur>
            <feColorMatrix
              values="0 0 0 0 0   0 0 0 0 0   0 0 0 0 0  0 0 0 0.1 0"
              type="matrix"
              in="shadowBlurOuter1"
              result="shadowMatrixOuter1"
            ></feColorMatrix>
            <feMerge>
              <feMergeNode in="shadowMatrixOuter1"></feMergeNode>
              <feMergeNode in="SourceGraphic"></feMergeNode>
            </feMerge>
          </filter>
        </defs>
        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
          <g
            id="Media-Manager---Grid-View---Folder-Selected"
            transform="translate(-296.000000, -234.000000)"
          >
            <g id="Intro">
              <g id="Concentric-circles">
                <mask id="mask-2" fill="white">
                  <use xlink:href="#path-1"></use>
                </mask>
                <use id="Mask" fill="#2D2D2D" xlink:href="#path-1"></use>
              </g>
            </g>
            <g
              id="Group"
              transform="translate(304.000000, 194.000000)"
              fill-rule="nonzero"
            >
              <g
                id="folder"
                filter="url(#filter-3)"
                transform="translate(0.000000, 47.000000)"
              >
                <path
                  d="M18.683964,15.1682851 L1.05263431,15.1682851 C0.471274699,15.1682851 -3.71335547e-14,14.6970104 -3.71335547e-14,14.1156508 L-3.71335547e-14,1.06915548 C-3.71335547e-14,0.487795865 0.471274699,0.0165211663 1.05263431,0.0165211663 L6.02988854,0.0165211663 C6.41017039,0.0165211663 6.76090801,0.221644933 6.94736117,0.553121905 L7.52783572,1.5851469 C7.71424674,1.91662388 8.06498436,2.12174764 8.44530835,2.12174764 L18.6840483,2.12174764 C19.2654079,2.12174764 19.7366826,2.59302234 19.7366826,3.17438196 L19.7366826,14.1156508 C19.7366826,14.6970104 19.2653236,15.1682851 18.683964,15.1682851 Z"
                  id="Path"
                  fill="#AAAAAA"
                ></path>
                <path
                  d="M1.05263431,15.5054518 L18.683964,15.5054518 C19.2653236,15.5054518 19.7365983,15.0341771 19.7365983,14.4528175 L19.7365983,3.51159076 C19.7365983,2.93023115 19.2653236,2.45895645 18.683964,2.45895645 L11.0751661,2.45895645 C10.6948843,2.45895645 10.3441467,2.66408022 10.1576935,2.99555719 L9.57721897,4.02758219 C9.39080795,4.35905916 9.04007034,4.56418293 8.65974634,4.56418293 L1.05263431,4.56418293 C0.471274699,4.56418293 -4.5518551e-14,5.03545763 -4.5518551e-14,5.61681724 L-4.5518551e-14,14.4528175 C-4.5518551e-14,15.0341771 0.471274699,15.5054518 1.05263431,15.5054518 Z"
                  id="Path"
                  fill="#808080"
                ></path>
              </g>
            </g>
          </g>
        </g>
      </svg>
      <h6>{{ item.directoryname }}</h6>
      <span class="date">{{ $t("actions.created_on") }} {{ item.created_at }}</span>
    </div>
  </div>
</template>

<script>
export default {
  name: "mmfoldercard",
  props: ["item"],
  data() {
    return {};
  },
  methods: {},
  mounted() {},
};
</script>
