import Modeler from "bpmn-js/lib/Modeler";
import {
    BpmnPropertiesPanelModule,
    BpmnPropertiesProviderModule,
} from "bpmn-js-properties-panel";

const emptyXml = `
<?xml version="1.0" encoding="UTF-8"?>
<bpmn2:definitions xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:bpmn2="http://www.omg.org/spec/BPMN/20100524/MODEL" xmlns:bpmndi="http://www.omg.org/spec/BPMN/20100524/DI" xmlns:dc="http://www.omg.org/spec/DD/20100524/DC" xmlns:di="http://www.omg.org/spec/DD/20100524/DI" id="definitions" targetNamespace="http://bpmn.io/schema/bpmn" exporter="Camunda Modeler" exporterVersion="4.7.0">
  <bpmn2:process id="process" name="Process">
  </bpmn2:process>
  <bpmndi:BPMNDiagram id="BPMNDiagram">
    <bpmndi:BPMNPlane id="BPMNPlane" bpmnElement="process">
    </bpmndi:BPMNPlane>
  </bpmndi:BPMNDiagram>
</bpmn2:definitions>
`;

export function createModeler(initialXml, containerElementId) {
    const el = document.getElementById(containerElementId);

    const modeler = new Modeler({
        container: el,
        keyboard: {
            bindTo: window,
        },
        propertiesPanel: {
            parent: document.getElementById("properties-container"),
        },
        additionalModules: [
            BpmnPropertiesPanelModule,
            BpmnPropertiesProviderModule,
        ],
    });

    modeler.importXML(initialXml);

    return modeler;
}

export function saveXml(modeler, cb) {
    try {
        modeler.saveXML({ format: true }).then((result) => {
            cb(result.xml);
        });
    } catch (err) {
        console.error("could not save BPMN 2.0 diagram", err);
    }
}

export function exportXml(modeler, modelName) {
    try {
        modeler.saveXML({ format: true }).then((result) => {
            const blob = new Blob([result], { type: "text/xml" });
            const url = window.URL.createObjectURL(blob);
            const link = document.createElement("a");
            link.href = url;
            link.download = `${modelName}.xml`;
            link.click();
            window.URL.revokeObjectURL(url);
        });
    } catch (err) {
        console.error("could not save BPMN 2.0 diagram", err);
    }
}
