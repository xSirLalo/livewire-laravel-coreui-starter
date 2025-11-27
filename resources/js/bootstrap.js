import * as coreui from "@coreui/coreui";
window.coreui = coreui;

import "/node_modules/simplebar/dist/simplebar.min.js";

import { Chart, registerables } from "chart.js";
import * as ChartJSPlugins from "@coreui/chartjs";
import * as CoreUIUtils from "@coreui/utils";

Chart.register(...registerables);
window.Chart = Chart;
window.coreui = {
    ...coreui,
    ChartJS: ChartJSPlugins,
    Utils: CoreUIUtils,
};

import { getStyle } from "@coreui/utils";
window.getStyle = getStyle;

import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
