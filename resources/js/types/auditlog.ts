export type AuditLogs = {
    id: number;
    userId: number;
    username: string;
    action: string;
    targetType: string;
    targetNumber: string;
    createdAt: string;
    updatedAt: string;
};
