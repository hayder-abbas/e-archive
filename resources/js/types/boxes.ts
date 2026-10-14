import { Links, Meta } from "./paginate";

export type Box = {
    id: number;
    boxName: string;
    boxNumber: string;
    boxDate: string;
};

export type Boxes = {
    data: Box[];
    links: Links;
    meta: Meta;
};
