<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExamImport implements ToCollection, WithHeadingRow
{
    private array $groups = [];

    private array $errors = [];

    public function collection(Collection $rows): void
    {
        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2;
            $rawRow = is_object($row) && method_exists($row, 'toArray')
                ? $row->toArray()
                : (array) $row;

            if ($this->isEmptyRow($rawRow)) {
                continue;
            }

            $data = $this->normalizeRow($rawRow);

            $validator = Validator::make($data, [
                'exam_code' => ['required', 'string', 'max:100'],
                'title' => ['required', 'string', 'max:255'],
                'class_id' => ['nullable', 'integer', 'exists:classes,id'],
                'description' => ['nullable', 'string', 'max:2000'],
                'status' => ['required', 'boolean'],
                'question' => ['required', 'string', 'max:2000'],
                'option_a' => ['required', 'string', 'max:500'],
                'option_b' => ['required', 'string', 'max:500'],
                'option_c' => ['required', 'string', 'max:500'],
                'option_d' => ['required', 'string', 'max:500'],
                'option_e' => ['nullable', 'string', 'max:500'],
                'answer' => ['required', 'string', 'in:A,B,C,D,E'],
            ]);

            $validator->after(function ($validator) use ($data) {
                if ($data['answer'] === 'E' && trim($data['option_e']) === '') {
                    $validator->errors()->add('answer', 'Kunci E membutuhkan opsi E.');
                }
            });

            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $error) {
                    $this->errors[] = "Baris {$rowNumber}: {$error}";
                }

                continue;
            }

            $groupKey = strtolower($data['exam_code']);
            $this->groups[$groupKey]['rows'][] = $data + ['row_number' => $rowNumber];
        }

        $this->validateGroupMetadata();
    }

    public function exams(): array
    {
        return collect($this->groups)->map(function (array $group): array {
            $first = $group['rows'][0];

            return [
                'title' => $first['title'],
                'class_id' => $first['class_id'] ?: null,
                'description' => $first['description'] ?: null,
                'status' => (bool) $first['status'],
                'questions' => collect($group['rows'])->map(function (array $row): array {
                    $options = [
                        'A' => $row['option_a'],
                        'B' => $row['option_b'],
                        'C' => $row['option_c'],
                        'D' => $row['option_d'],
                    ];

                    if ($row['option_e'] !== '') {
                        $options['E'] = $row['option_e'];
                    }

                    return [
                        'question' => $row['question'],
                        'options' => $options,
                        'answer' => $row['answer'],
                    ];
                })->values()->all(),
            ];
        })->values()->all();
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return $this->errors !== [];
    }

    public function questionCount(): int
    {
        return collect($this->groups)->sum(fn (array $group) => count($group['rows']));
    }

    private function normalizeRow(array $row): array
    {
        $status = strtolower(trim((string) ($row['status'] ?? '')));
        if (in_array($status, ['1', 'true', 'aktif', 'active', 'ya', 'yes'], true)) {
            $status = 1;
        } elseif ($status === '' || in_array($status, ['0', 'false', 'nonaktif', 'inactive', 'tidak', 'no'], true)) {
            $status = 0;
        }

        $classId = $row['class_id'] ?? null;
        if (is_numeric($classId) && (float) $classId == (int) $classId) {
            $classId = (int) $classId;
        }

        return [
            'exam_code' => trim((string) ($row['exam_code'] ?? '')),
            'title' => trim((string) ($row['title'] ?? '')),
            'class_id' => $classId,
            'description' => trim((string) ($row['description'] ?? '')),
            'status' => $status,
            'question' => trim((string) ($row['question'] ?? '')),
            'option_a' => trim((string) ($row['option_a'] ?? '')),
            'option_b' => trim((string) ($row['option_b'] ?? '')),
            'option_c' => trim((string) ($row['option_c'] ?? '')),
            'option_d' => trim((string) ($row['option_d'] ?? '')),
            'option_e' => trim((string) ($row['option_e'] ?? '')),
            'answer' => strtoupper(trim((string) ($row['answer'] ?? ''))),
        ];
    }

    private function isEmptyRow(array $row): bool
    {
        return collect($row)->every(fn ($value) => trim((string) $value) === '');
    }

    private function validateGroupMetadata(): void
    {
        foreach ($this->groups as $group) {
            $first = $group['rows'][0];

            foreach (array_slice($group['rows'], 1) as $row) {
                foreach (['title', 'class_id', 'description', 'status'] as $field) {
                    if ((string) $row[$field] !== (string) $first[$field]) {
                        $this->errors[] = "Baris {$row['row_number']}: kolom {$field} harus sama untuk exam_code {$first['exam_code']}.";
                    }
                }
            }
        }
    }
}
